<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'logo_show',
        'description',
        'lang',
        'theme',
        'admin_theme',
        'layout_id',
        'active',
        'registration',
        'version',
    ];
    protected $casts = [
      'theme' => 'array' ,
      'admin_theme' => 'array'
    ];
    const THEMES_ARRAY = [
        'coral_light' => 'Coral Theme',
        'ronin' => 'Ronin Theme'
    ];
    const ADMIN_THEMES_ARRAY = [
        'star_admin' => 'Star Admin Theme',
        'coral_admin' => 'Coral Admin Theme',
    ];
    const THEME_FRAMEWORK_BOOTSTRAP = 1;
    const THEME_FRAMEWORK_UIKIT = 2;
}
