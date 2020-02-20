<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    protected $fillable = ['title', 'slug', 'description', 'image',
        'layout_id', 'user_id', 'attachments', 'view_attachments',
        'meta_title', 'meta_keywords', 'meta_description', 'status',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
