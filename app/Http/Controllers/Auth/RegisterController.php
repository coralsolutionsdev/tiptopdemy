<?php

namespace App\Http\Controllers\Auth;

use App\Institution\Directorate;
use App\Institution\InstitutionScope;
use App\Institution\InstitutionScopeField;
use App\Institution\InstitutionScopeFieldOption;
use App\Jobs\SendValidationMail;
use App\Role;
use App\UniqueId;
use App\User;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use http\Env\Request;
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
        $this->middleware(['guest','active'], ['except' => ['getInstitutionScopeFields','getInstitutionScopeFieldOptions', 'getInstitutionScopeFieldLevels', 'getCountryDirectorates']]);
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
            'phone_number' => 'string',
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
        $username = UniqueId::generate(['table' => 'users', 'length' => 8, 'prefix' =>'STU']);
        // recaptcha validation
        $captcha = $data['g-recaptcha-response'];
        $client = new Client([
            'base_uri' => 'https://google.com/recaptcha/api/',
            'timeout' => 2.0
        ]);
        $response = $client->request('POST', 'siteverify', [
            'query' => [
                'secret' => config('baseapp.google_recaptcha_secret'),
                'response' => $captcha]
        ]);
        $response = json_decode($response->getBody()->getContents(), true);
        if (!$response['success']){
            return null;
        }
        $user = User::create([
            'name' => $data['first_name'].' '.$data['middle_name'].' '.$data['last_name'].' '.$data['surname'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'surname' => $data['surname'],
            'mother_name' => !empty($data['mother_name']) ? $data['mother_name'] : null,
            'email' => $data['email'],
            'username' => $username,
            'gender' => $data['gender'],
            'phone_number' => !empty($data['phone_number']) ? $data['phone_number'] : null,
            'birth_date' => !empty($data['birth_date']) ? $data['birth_date'] : null,
            'lang' => getSite()->lang,
            'password' => bcrypt($data['password']),
            // TipTop fields
            'country_id' => $data['country_id'],
            'directorate_id' => !empty($data['directorate_id']) ? $data['directorate_id'] : null,
            'scope_id' => !empty($data['scope_id']) ? $data['scope_id'] : null,
            'field_id' => !empty($data['field_id']) ? $data['field_id'] : null,
            'field_option_id' => !empty($data['field_option_id']) ? $data['field_option_id'] : null,
            'level' => !empty($data['level']) ? $data['level'] : null,
        ]);
        User::findOrFail($user->id);

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
                $items =  $scope->fields()->orderBy('position')->where('status', 1)->get();
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
                $items =  $field->options()->orderBy('position')->where('status', 1)->get();
                return response(['items' => $items], 200);
            }
        }
    }
    /**
     * @param $fieldId
     * @return ResponseFactory|Response
     */
    public function getInstitutionScopeFieldLevels($fieldId)
    {
        if (!empty($fieldId)){
            $field = InstitutionScopeField::find($fieldId);
            if (!empty($field)){
                $items =  $field->levels;
                return response(['items' => $items], 200);
            }
        }
    }

    /**
     * @param $countryId
     * @return ResponseFactory|Response
     */
    public function getCountryDirectorates($countryId)
    {
        if (!empty($countryId)){
                $items =  Directorate::orderBy('position')->where('country_id', $countryId)->where('status', 1)->get();
                return response(['items' => $items], 200);
            }
    }
}
