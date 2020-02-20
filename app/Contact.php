<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'title',
        'content',
        'map_coordinates',
        'items',
        'status',
    ];
    protected $casts = [
        'items' => 'array'
    ];
}
