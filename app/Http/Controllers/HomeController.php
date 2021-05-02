<?php

namespace App\Http\Controllers;

use App\Jobs\SendValidationMail;
use App\Mail\ValidationMail;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       //$this->middleware('authuser');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->status == 0){
            return redirect()->route('verification');
        }
        return view('profile.index');
    }

    public function template(){
        $user = Auth::user();
        $email = $user->email;
        $validationCode =  !empty($email) ? generateValidationCode($email) : null;
        $data['receiver_name'] = $user->first_name;
        $data['receiver_email'] = $email;
        $data['validation_code'] = $validationCode;
        try {
            Mail::to($data['receiver_email'])->send(new ValidationMail($data));
        } catch (\Exception $e) {
            dd($e);
        }
        dd('done');
        return view('template');
    }

    public function suspended(){
        $modelName = 'Profile';
        $user = Auth::user();
        $page_title = __('main.Home page');
        $breadcrumb =  Breadcrumbs::render('profile');
        if (!$user){
            return redirect()->route('main');
        }
        $status = $user->status;
        if($status == User::STATUS_PENDING || $status == User::STATUS_DISABLED){
            return view('profile.verification', compact('status', 'modelName', 'page_title', 'breadcrumb'));
        }
        return redirect()->route('main', compact('modelName', 'page_title', 'breadcrumb'));
        

        
    }
    public function sendVerifyEmailDone($email,$verify_token){
        
        $user = User::where(['email'=>$email,'verify_token'=>$verify_token])->first();

        if($user){
            $user->status = 1;
            $user->verify_token = null;
            $user->save();
            session()->flash('success', 'Acount activated');

            //return 'user exist';
        }else{
            session()->flash('warning', 'Acount already activated!!');
            //return 'user exist';
  
        }
        return redirect()->route('home');

    }

    
}
