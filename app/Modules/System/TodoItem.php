<?php

namespace App\Modules\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoItem extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'type',
        'priority',
        'creator_id',
        'editor_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(\App\Modules\System\User::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\Modules\System\User::class);
    }

    public function editor()
    {
        return $this->belongsTo(\App\Modules\System\User::class);
    }
}
