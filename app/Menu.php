<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
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

    public function menu()
    {
    	return $this->belongsTo('App\Menu');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
