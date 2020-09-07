<?php

namespace App\Http\Controllers\Site;

use App\Jobs\SendValidationMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\BlogPost;
use App\GalleryImage;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
     public function __construct()
    {
    $this->middleware('auth', ['only' => ['index','edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
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
        //
        $posts_count = BlogPost::all()->where('user_id', '=', $id)->count();
        $pictures_count = GalleryImage::all()->where('user_id', '=', $id)->count();
        $user = User::find($id);
        return view('profile.edit', compact('user', 'posts_count', 'pictures_count'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */

    public function update(Request $request)
    {
        $input = $request->only(['avatar']); //TODO: update all all
        $user = getAuthUser();
        $user->update($input);
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



}
