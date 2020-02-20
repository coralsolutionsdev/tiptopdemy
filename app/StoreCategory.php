<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    const CATEGORY_PRODUCTS = 1;
    //
    protected $fillable = ['name','description','image','type','status'];

}
