<?php

namespace App;

use App\Modules\Comment\Commenter;
use App\Modules\Store\Order;
use Bnb\Laravel\Attachments\HasAttachment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laratrust\Traits\LaratrustUserTrait;
use Cog\Contracts\Love\Reacterable\Models\Reacterable as ReacterableContract;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;
use Webpatser\Countries\Countries;

class User extends Authenticatable implements ReacterableContract
{
    use Notifiable;
    use LaratrustUserTrait;
    use Reacterable;
    use HasAttachment;
    use Commenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'first_name', 'middle_name', 'last_name', 'surname', 'mother_name', 'email', 'gender','phone_number', 'birth_date', 'avatar', 'image', 'cover', 'lang', 'verify_token', 'status', 'password', 'country_id',
        'directorate_id', 'scope_id', 'field_id', 'field_option_id', 'level', 'username'
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
     * Avatars
     */
    const AVATARS_ARRAY = [
        'avatar_group_0' => [
           '/images/avatars/group_0/01.png',
           '/images/avatars/group_0/02.png',
           '/images/avatars/group_0/03.png',
           '/images/avatars/group_0/04.png',
        ],
        'avatar_group_2' => [
            '/images/avatars/group_2/01.png',
            '/images/avatars/group_2/02.png',
            '/images/avatars/group_2/03.png',
            '/images/avatars/group_2/04.png',
            '/images/avatars/group_2/05.png',
            '/images/avatars/group_2/06.png',
            '/images/avatars/group_2/07.png',
//            '/images/avatars/group_2/08.png',
            '/images/avatars/group_2/09.png',
        ],
    ];
    public function getAvatarGroups(){
        $groups = self::AVATARS_ARRAY;
        return $groups;
    }

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
                $url = asset_image('images/avatars/group_2/01.png');
            }else{
                $url = asset_image('images/avatars/group_2/02.png');
            }
        }
        return $url;
    }
    public function getUserName($fullName = false)
    {
        $name = $this->name;
        return $name;
    }

    public function getCompanyId()
    {
        return 1;
    }
    public function getCourses($productTypeId = null)
    {
        if (!is_null($productTypeId)){
            return $this->products()->where('product_type_id', $productTypeId)->get();
        }
        return $this->products;
    }
    public function profileImages()
    {
        return $this->attachments()->where('group', 'profile_images')->get();
    }
    /*
     |--------------------------------------------------------------------------
     | Relationship Methods
     |--------------------------------------------------------------------------
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_user')->withPivot('quantity');
    }
    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'creator_id')->latest();
    }


}
