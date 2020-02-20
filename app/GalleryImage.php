<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'image',
        'album_id',
        'status',
        'user_id',
    ];

    public function album()
    {
    	return $this->belongsTo('App\GalleryAlbum');
    }
     public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
