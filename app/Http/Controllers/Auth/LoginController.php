<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
//    use Socialite;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     * @param $driver
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     * @param $driver
     * @return mixed
     */
    public function handleProviderCallback($driver)
    {

        $socialUser = Socialite::driver($driver)->user();
        $name = $socialUser->name;
        $email = $socialUser->email;
        $backUrl =  redirect()->back();
        $user = User::where('email', $email)->first();
        if (!empty($user)){
            // login
            if (!empty(session('lastUrl'))) {
               $backUrl =  session('lastUrl');
            }
            Auth::login($user, true);
            return redirect($backUrl);
        }else{
            return view('auth.register', compact('name', 'email'));
        }
    }
}
