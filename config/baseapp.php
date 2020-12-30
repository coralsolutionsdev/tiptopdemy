<?php

/**
 * This file is part of Laratrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Laratrust
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Storage path locations
    |--------------------------------------------------------------------------
    */
    'banner_image_storage_path'   =>  'images' . '/' . 'banners',
    'post_image_storage_path'   =>  'images' . '/' . 'posts',
    'page_image_storage_path'   =>  'images' . '/' . 'pages',
    'user_image_storage_path'   =>  'images' . '/' . 'profile_pictures',
    'product_image_storage_path'   =>  'images' . '/' . 'products',
    'attachments_storage_path'   =>  'images' . '/' . 'products',

    /*
    |--------------------------------------------------------------------------
    | API Keys
    |--------------------------------------------------------------------------
    |
    | 3rd party API keys here
    |
    */
//    'google_maps_js_api' => env('GOOGLE_MAPS_JS_API', ''),
    'google_recaptcha_key' => env('RECAPTCHA_SITE_KEY', ''),
    'google_recaptcha_secret' => env('RECAPTCHA_SECRET_KEY', ''),
];
