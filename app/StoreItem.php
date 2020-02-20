<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    //
    protected $fillable = ['name','description','image','category_id','quantity','price','discount','featured','status'];

    /*
     * relasionsips
     */
    public function category()
    {
        return $this->belongsTo('App\StoreCategory','category_id');
    }
}
