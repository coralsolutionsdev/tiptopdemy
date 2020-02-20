<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    //
    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }
}
