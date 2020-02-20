<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\GalleryImage;

class GalleryAlbum extends Model
{
    use Sluggable;


    function getAlbumCover(){
        $images = $this->images()->get();
        $cover= $images->sortByDesc('id')->first();
        return $cover;
    }

    /*
     *
     */
    public function images()
    {
    	return $this->hasMany('App\GalleryImage','album_id');
    }

     public function user()
    {
    	return $this->belongsTo('App\User');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function getCoverImage()
    {
        $cover = 'temp/no-image.png';
        $images = $this->images;
        if (!empty($images) && !empty($images->last())){
            $cover = $images->last()->image;
        }
        return $cover;
    }
    public function getImagesCount()
    {
        $count = 0;
        $images = $this->images;
        if (!empty($images)){
            $count = $images->count();
        }
        return $count;
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
