<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'first_name', 'middle_name', 'last_name', 'surname', 'mother_name', 'email', 'gender','phone_number', 'birth_date', 'avatar', 'cover', 'lang', 'verify_token', 'status', 'password', 'country_id',
        'directorate_id', 'scope_id', 'field_id', 'field_option_id', 'level'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 0;

    const GENDER_ARRAY = [
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female',
    ];

    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;
    const STATUS_TYPE_ARRAY = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_DISABLED => 'Disabled'
    ];

    /**
     * Gets the first role title
     *
     * @param $tenantId The associated company_id
     * @return mixed
     */
    public function getRole() {

        $role = collect();
        if ($this->roles()->first() != null) {
            $role =  $this->roles()->first();
        }
        return $role;
    }

    public function IsAdmin(){
        if (Auth::user()->role == 'admin'){
            return true;
        }
        return false;
    }
    /**
     * Checks if the user is an Administrator
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->roles()->where('name', 'superadministrator')->first() != null;
    }
    /**
     * return user gender
     *
     * @return string
     */
    public function getGender()
    {
        if ($this->gender == 1){
            $gender ='male';
        }else{
            $gender ='female';
        }
        return $gender;
    }

    /**
     * Return profile picture url
     * @return string
     */
    public function getProfilePicURL()
    {
        if (!empty($this->avatar)){
            $url = asset_image($this->avatar);
        }else{
            if ($this->gender == 1){
                $url = asset_image('temp/male.png');
            }else{
                $url = asset_image('temp/female.png');
            }
        }
        return $url;
    }
    public function getUserName($fullName = false)
    {
        $name = $this->name;
        return $name;
    }

}
