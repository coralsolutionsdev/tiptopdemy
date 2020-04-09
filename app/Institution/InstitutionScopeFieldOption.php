<?php

namespace App\Institution;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class InstitutionScopeFieldOption extends Model
{
    use Sluggable;

    protected $fillable = [
        'title', 'slug', 'description', 'field_id', 'user_id', 'position', 'default', 'status',
    ];

    const TYPE_GENERAL = 0;
    const TYPE_GENERAL2 = 1;
    const TYPE_ARRAY = [
        self::TYPE_GENERAL => 'General',
        self::TYPE_GENERAL2 => 'General2',
    ];

    /**
     * Return the sluggable configuration array for this model.
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['title', '']
            ]
        ];
    }

}
