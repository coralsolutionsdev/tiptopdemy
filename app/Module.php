<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //
    protected $fillable = ['name','main_module','display_name','status'];

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

}
