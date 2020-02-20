<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $fillable = [
        'title',
        'description',
        'container_type',
        'grid',
        'structure',
        'status',
        'theme'
    ];
    protected $casts = [
        'structure' => 'array',
        'grid' => 'array',
    ];
    const CONTAINER = 1;
    const CONTAINER_FLUID = 2;
    // models
    const LAYOUT_MODEL_BANNERS = 1;
    const LAYOUT_MODEL_BLOG = 2;
    const LAYOUT_MODEL_PRODUCTS = 3;
    const LAYOUT_MODEL_GALLERY = 4;

    const LAYOUT_MODELS_ARRAY = [
        self::LAYOUT_MODEL_BANNERS => 'Banners',
        self::LAYOUT_MODEL_BLOG => 'Blog posts',
        self::LAYOUT_MODEL_PRODUCTS => 'Products',
        self::LAYOUT_MODEL_GALLERY => 'Gallery',
    ];
    //sliders
    const LAYOUT_SLIDER_ARRAY = [
        1 => 'Default',
    ];
}
