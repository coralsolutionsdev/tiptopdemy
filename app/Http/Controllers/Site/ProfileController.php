<?php

namespace App\Http\Controllers\Site;

use App\Jobs\SendValidationMail;
use App\Modules\Media\Media;
use App\Product;
use App\Services\FileAssetManagerService;
use App\Services\MediaManagerService;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\BlogPost;
use App\GalleryImage;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Vinkla\Hashids\Facades\Hashids;

class ProfileController extends Controller
{
    protected $modelName;
    protected $page_title;
    protected $breadcrumb;

    public function __construct()
    {
        $this->modelName = 'Profile';
        $this->middleware('auth', ['only' => ['index','edit','update']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelName = $this->modelName;
        $page_title = __('main.Home page');
        $breadcrumb =  Breadcrumbs::render('profile');
        $user = Auth::user();
        $usersCount = User::count() - 1;
        return view('profile.index', compact('modelName', 'page_title', 'breadcrumb', 'user', 'usersCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $posts_count = BlogPost::all()->where('user_id', '=', $id)->count();
        $pictures_count = GalleryImage::all()->where('user_id', '=', $id)->count();

        //blog
        $user = User::find($id);
        return view('profile.show', compact('user', 'posts_count', 'pictures_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $modelName = $this->modelName;
        $page_title = __('main.Edit Profile');
        $breadcrumb =  Breadcrumbs::render('profile.edit', $user);
        $posts_count = BlogPost::all()->where('user_id', '=', $id)->count();
        $pictures_count = GalleryImage::all()->where('user_id', '=', $id)->count();
        $countries = getCountries()->pluck('name', 'id')->toArray();
        $directorates = getCountryDirectorates(368)->pluck('title', 'id')->toArray();
        $scopes = getInstitutionScopes(368)->pluck('title', 'id')->toArray(); // iraq
        $mediaType = Media::TYPE_PRODUCT_IMAGE;
        return view('profile.edit', compact('modelName','page_title', 'breadcrumb', 'user', 'posts_count', 'pictures_count', 'countries', 'directorates', 'scopes', 'mediaType'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */

    public function update(Request $request)
    {
        $user = getAuthUser();
        $input = $request->only($user->getFillable());
        // update password
        $passwordInputs = $request->only(['current_password', 'new_password', 'confirm_new_password']);
        if (isset($passwordInputs['current_password'])){
            if (!Hash::check($passwordInputs['current_password'], $user->password)){
                session()->flash('danger', 'Your current password is not matching the password in our record.');
                return redirect()->back();
            }
            if($passwordInputs['new_password'] != $passwordInputs['confirm_new_password']){
                session()->flash('danger', 'Your new password is not matching the confirm password.');
                return redirect()->back();
            }
            $input['password'] = bcrypt($passwordInputs['new_password']);

        }
        $user->update($input);

        $updatedTab = isset($request->updated_tab) ? $request->updated_tab : null;
        // media upload
        if (isset($updatedTab) && $updatedTab == 2){
            $mediaInput = $request->only(['media_removed_ids', 'media_position', 'media_id', 'media_files', 'media_new_file_order']);
            $mediaType = Media::TYPE_PROFILE_IMAGE;
            $productMedia = $user->getMedia(Media::getGroup($mediaType));
            // removed media items
            $mediaRemovedItems = isset($mediaInput['media_removed_ids']) && !empty($mediaInput['media_removed_ids']) ? $mediaInput['media_removed_ids'] :  array();
            if (!empty($mediaRemovedItems)){
                foreach ($mediaRemovedItems as $mediaRemovedItemId){
                    $removedProductMedia = $productMedia->where('id', $mediaRemovedItemId)->first();
                    if (!empty($removedProductMedia)){
                        $removedProductMedia->delete();
                    }
                }
            }

            if (isset($mediaInput['media_position'])){
                $mediaPosition = $mediaInput['media_position'];
                if (!empty($mediaPosition)){
                    foreach ($mediaPosition as $position => $value){
                        if (isset($mediaInput['media_id'][$position]) && !empty($mediaInput['media_id'][$position])){
                            $mediaItem = $productMedia->where('id', $mediaInput['media_id'][$position])->first();
                            if (!empty($mediaItem)){
                                // update position
                                $mediaItem->order_column = $position;
                                $mediaItem->save();

                            }else { // add new item

                                $image = $mediaInput['media_files'][$mediaInput['media_new_file_order'][$position]];

                                $newMediaItem = MediaManagerService::store($user, $mediaType, $image);
//                            dd('here', $newMediaItem);

                                if ($newMediaItem){
                                    $newMediaItem->order_column = $position;
                                    $newMediaItem->save();
                                }
                            }
                        }

                    }

                }
            }else{ // no product images
                $user->clearMediaCollection(Media::getGroup($mediaType));
            }
        }
        session()->flash('success', trans('main._update_msg'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * verify registered email and activate the account
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function verifyEmail(Request $request)
    {
        if (Auth::check() ){
            $user = Auth::user();
            if ($user->status == User::STATUS_PENDING){
                $validationCode = generateValidationCode($user->email);
                $verifyEmail =  $request->verify_email;
                if (!empty($validationCode) && !empty($verifyEmail)){
                    if ($verifyEmail == $validationCode){
                        $user->status = User::STATUS_ACTIVE;
                        $user->save();
                        session()->flash('success', __('Your account has been activated successfully.'));
                        return redirect()->route('profile.index');
                    }
                }
                session()->flash('warning', __('Unable to activate the account please try again or contact our customer services.'));
                return redirect()->route('profile.index');
            } elseif ($user->status == User::STATUS_ACTIVE){
                session()->flash('warning', __('Your account is already activated.'));
                return redirect()->route('profile.index');
            }else{
                session()->flash('warning', __('Unable to activate the account please try again or contact our customer services.'));
                return redirect()->route('main');
            }
        }else{
            session()->flash('warning', __('Activation failed, please login first then click on activation link.'));
            return redirect()->route('main');
        }
    }


    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function reSendActivationEmail(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => 'required',
        ]);

        $input = $request->only(['g-recaptcha-response']);
        $captcha = $input['g-recaptcha-response'];
        $response = recaptchaValidate($captcha);
        if (!$response['success']){
            session()->flash('warring', __('captcha is not correct.'));
            return redirect()->back();
        }
        $user = Auth::user();
        if (!empty($user)){
            // send validation email
            $email = $user->email;
            $validationCode =  !empty($email) ? generateValidationCode($email) : null;
            $data['receiver_name'] = $user->first_name;
            $data['receiver_email'] = $email;
            $data['validation_code'] = $validationCode;
            SendValidationMail::dispatch($data);
            session()->flash('success', __('You will receive your activation mail soon, please check your email.'));
            return redirect()->back();
        }else{
            return redirect('/');
        }
    }

    /**
     * View user Products
     * @return Application|Factory|View
     */
    public function coursesIndex()
    {
        $modelName = $this->modelName;
        $page_title = __('main.My Courses');
        $breadcrumb =  Breadcrumbs::render('courses');
        $user = Auth::user();
        $products = $user->getCourses(Product::TYPE_COURSES); //view only lessons
        return view('profile.course.index', compact('modelName', 'page_title' ,'breadcrumb', 'user', 'products'));
    }

    /**
     * View user Products
     * @return Application|Factory|View
     */
    public function ordersIndex()
    {
        $modelName = $this->modelName;
        $page_title = __('main.My Orders');
        $breadcrumb =  Breadcrumbs::render('orders');
        $user = Auth::user();
        $orders = $user->orders; //view only lessons
        return view('profile.orders.index', compact('modelName', 'page_title' ,'breadcrumb', 'user', 'orders'));
    }
    /**
     * View user Products
     * @return Application|Factory|View
     */
    public function observersIndex()
    {
        $modelName = $this->modelName;
        $page_title = __('main.Observers List');
        $breadcrumb =  Breadcrumbs::render('observers');
        $user = Auth::user();
        $orders = $user->orders; //view only lessons
        return view('profile.observers.index', compact('modelName', 'page_title' ,'breadcrumb', 'user', 'orders'));
    }



}
