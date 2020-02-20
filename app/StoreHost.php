<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreHost extends Model
{
    //
    protected $fillable = ['plan_name','description','storage','bandwidth','databases','price','discount','featured','status'];
}
