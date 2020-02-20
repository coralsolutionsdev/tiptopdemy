<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\BlogPost;
use Auth;

class LoginController extends Controller
{
    //
    public function login(Request $request){
    	
    	if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
    	{
    		$user = User::where('email', $request->email)->first();
    		if($user->hasRole('superadministrator') OR $user->hasRole('administrator')){
                return redirect()->route('admin.dashboard');
            }
//            return redirect()->route('home');
            return redirect()->back();


        }
    	return redirect()->back();


    }
    public function GetAdmin(){
        $postcount = BlogPost::where('id','>=','1')->count();
        $usercount = User::where('id', '>=', '1')->count();
        return view('admin', compact('postcount','usercount'));
        
    }
}
