<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\mail\NewUser;
use Mail;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/verification';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest','active']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => 'required|bool',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if($data['gender'])
            { $avatar = 'male.png';}
        else
            { $avatar = 'female.png'; }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'lang' => getSite()->lang,
//            'avatar' => $avatar,
            'password' => bcrypt($data['password']),
            'verify_token' => str_random(60),
        ]);

        $thisuser = User::findOrFail($user->id);
        $this->sendVerifyEmail($thisuser);
        $updated_role = Role::where('name', 'user')->first();
        if (!empty($updated_role)){
            $user->attachRole($updated_role);
        }

        return $user;
    }

    public function sendVerifyEmail($thisuser)
    {
        Mail::to($thisuser['email'])->send(new NewUser($thisuser));
    }

}
