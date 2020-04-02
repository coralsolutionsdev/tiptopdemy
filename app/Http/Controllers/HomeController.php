<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

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
        return view('template');
    }

    public function suspended(){
        $status = Auth::user()->status;
        if($status == User::STATUS_PENDING || $status == User::STATUS_DISABLED){
            return view('profile.verification', compact('status'));
        }
        return redirect()->route('main');
        

        
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
