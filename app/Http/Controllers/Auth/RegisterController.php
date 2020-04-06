<?php

namespace App\Http\Controllers\Auth;

use App\Institution\InstitutionScope;
use App\Institution\InstitutionScopeField;
use App\Institution\InstitutionScopeFieldOption;
use App\Jobs\SendValidationMail;
use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
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
    protected $redirectTo = '/suspended';

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
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
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
        $user = User::create([
            'name' => $data['first_name'].' '.$data['middle_name'].' '.$data['last_name'].' '.$data['surname'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'surname' => $data['surname'],
            'mother_name' => $data['mother_name'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'],
            'birth_date' => $data['birth_date'],
            'lang' => getSite()->lang,
            'password' => bcrypt($data['password']),
            // TipTop fields
            'directorate_id' => $data['directorate_id'],
            'country_id' => $data['country_id'],
            'scope_id' => !empty($data['scope_id']) ? $data['scope_id'] : null,
            'field_id' => !empty($data['field_id']) ? $data['field_id'] : null,
            'field_option_id' => !empty($data['field_option_id']) ? $data['field_option_id'] : null,
            'level' => $data['level'],
        ]);
        $thisuser = User::findOrFail($user->id);

        // add user role to the registered user
        $updated_role = Role::where('name', 'user')->first();
        if (!empty($updated_role)){
            $user->attachRole($updated_role);
        }

        // send validation email
        $email = $user->email;
        $validationCode =  !empty($email) ? generateValidationCode($email) : null;
        $data['receiver_name'] = $user->first_name;
        $data['receiver_email'] = $email;
        $data['validation_code'] = $validationCode;
        SendValidationMail::dispatch($data);

        return $user;
    }

    /**
     * @param $scopeId
     * @return ResponseFactory|Response
     */
    public function getInstitutionScopeFields($scopeId)
    {
        if (!empty($scopeId)){
            $scope = InstitutionScope::find($scopeId);
            if (!empty($scope)){
                $items =  $scope->fields->pluck('title','id')->toArray();
                return response(['items' => $items], 200);
            }
        }
    }

    /**
     * @param $fieldId
     * @return ResponseFactory|Response
     */
    public function getInstitutionScopeFieldOptions($fieldId)
    {
        if (!empty($fieldId)){
            $field = InstitutionScopeField::find($fieldId);
            if (!empty($field)){
                $items =  $field->options->pluck('title','id')->toArray();
                return response(['items' => $items], 200);
            }
        }
    }
}
