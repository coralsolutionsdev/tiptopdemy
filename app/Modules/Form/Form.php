<?php

namespace App\Modules\Form;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'version',
        'master_id',
        'ancestor_id',
        'submit_route',
        'type',
        'status',
        'position',
        'structure',
        'creator_id',
        'editor_id',
        'start_at',
        'expire_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'master_id' => 'integer',
        'ancestor_id' => 'integer',
        'status' => 'integer',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_at',
        'expire_at',
    ];


    public function master()
    {
        return $this->belongsTo(Form::class);
    }

    public function ancestor()
    {
        return $this->belongsTo(Form::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
