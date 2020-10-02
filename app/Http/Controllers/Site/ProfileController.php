<?php

namespace App\Http\Controllers\Site;

use App\Jobs\SendValidationMail;
use App\Product;
use App\Services\FileAssetManagerService;
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
        return view('profile.index', compact('modelName', 'page_title', 'breadcrumb', 'user'));
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
        return view('profile.edit', compact('modelName','page_title', 'breadcrumb', 'user', 'posts_count', 'pictures_count', 'countries', 'directorates', 'scopes'));
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

        // upload images
        $uploadImage = $request->only(['upload_image']);
        if (isset($uploadImage['upload_image'])){
            if ($request->hasFile('upload_image')) {
                // upload and save image
                $image = $request->file('upload_image');
                # code...
                $user->attach($image, [
                    'disk' => 'local',
                    'title' => 'any',
                    'group' => 'profile_images',
                ]);
            }
        }
        // delete images
        $deletedImages = $request->only(['deleted_images']);
        if (!empty($deletedImages)){
            foreach ($deletedImages['deleted_images'] as $deletedImage) {
                $image = $user->attachment($deletedImage);
                $image->delete();
            }
        }
        session()->flash('success', trans('main._update_msg'));
        return redirect()->back();
//
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


    public function reSendActivationEmail()
    {
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
