<?php

namespace App\Modules\Form;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormResponse extends Model
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
        'hash_id',
        'form_id',
        'ancestor_id',
        'responder_info',
        'score_info',
        'data',
        'properties',
        'status',
        'type',
        'notes',
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
        'form_id' => 'integer',
        'ancestor_id' => 'integer',
        'data' => 'array',
        'properties' => 'array',
        'score_info' => 'array',
        'status' => 'integer',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
    ];

    const STATUS_NOT_EVALUABLE = 0;
    const STATUS_FULLY_EVALUATED = 1;
    const STATUS_PARTIALLY_EVALUATED = 2;

    const STATUS_ARRAY = [
        self::STATUS_NOT_EVALUABLE => 'Not Evaluable',
        self::STATUS_FULLY_EVALUATED => 'Completed',
        self::STATUS_PARTIALLY_EVALUATED => 'Pending',
    ];

    const EVALUATION_TYPE_MANUAL = 0;
    const EVALUATION_TYPE_AUTO = 1;

    const EVALUATION_STATUS_PENDING = 0;
    const EVALUATION_STATUS_CORRECT = 1;
    const EVALUATION_STATUS_PARTIALLY_CORRECT = 2;
    const EVALUATION_STATUS_WRONG = 3;
    const EVALUATION_STATUS_lEAVE = 4;

    const PASSING_STATUS_FAILED = 0;
    const PASSING_STATUS_PASSED = 1;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'hash_id';
    }

    public function getStatus()
    {
        return self::STATUS_ARRAY[$this->status];
    }


    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function ancestor()
    {
        return $this->belongsTo(Form::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class);
    }
}
