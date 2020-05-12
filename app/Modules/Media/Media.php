<?php

namespace App\Modules\Media;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'type',
        'storage_type',
        'source',
        'status',
        'position',
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

    const TYPE_VIDEO = 1;

    const STORAGE_TYPE_YOUTUBE = 1;


    public function creator()
    {
        return $this->belongsTo(\App\Modules\Media\Creator::class);
    }

    public function editor()
    {
        return $this->belongsTo(\App\Modules\Media\Editor::class);
    }
}
