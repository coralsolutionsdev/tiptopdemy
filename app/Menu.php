<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Sluggable;

    protected $fillable = ['title','position','items','status','user_id'];
    protected $casts = [
        'items' =>'array'
    ];
    const POSITION_TOP_NAV = 1;
    const POSITION_FOOTER = 2;
    const POSITION_RIGHT_SIDE_BAR = 3;
    const POSITION_LEFT_SIDE_BAR = 4;
    const POSITIONS_ARRAY = [
        self::POSITION_TOP_NAV => 'Top navbar',
        self::POSITION_FOOTER => 'Footer',
        self::POSITION_RIGHT_SIDE_BAR => 'Right side bar',
        self::POSITION_LEFT_SIDE_BAR => 'Left side bar',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title', '']
            ]
        ];
    }
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    /*
     |--------------------------------------------------------------------------
     | Relationship Methods
     |--------------------------------------------------------------------------
     */
    public function menu()
    {
    	return $this->belongsTo('App\Menu');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
