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
        'name', 'email', 'password', 'gender', 'avatar', 'lang', 'verify_token', 'status'
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

}
