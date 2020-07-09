<?php

namespace App\Modules\Course;

use App\Modules\Form\Form;
use App\Modules\Group\Group;
use App\Modules\Media\Media;
use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;

class Lesson extends Model implements ReactableContract
{
    use Reactable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'product_id',
        'unit_id',
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
        'unit_id' => 'integer',
        'status' => 'integer',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
    ];

    const TYPE_PRESENTATION = 1;
    const TYPE_QUIZ = 2;

    const TYPES_ARRAY = [
        self::TYPE_PRESENTATION => 'Presentation',
        self::TYPE_QUIZ => 'Quiz',
    ];
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * return type
     * @return string
     */
    public function getType()
    {
        return self::TYPES_ARRAY[$this->type];
    }

    /**
     * @throws \Exception
     */
    public function deleteWithDependencies()
    {
        $this->media->each(function ($item) {
            $item->delete();
        });
        $this->delete();
    }

    /**
     * return lesson first media
     * @return mixed
     */
    public function getLessonFirstMedia()
    {
        if ($media = $this->media){
            return $media->first();
        }
    }

    /**
     * return latest version of each form item
     * @return mixed
     */
    public function getAvailableForms()
    {
        $forms = $this->forms->filter(function ($form) {
            if ($form->children->count() == 0){
                return true;
            }
            return false;
        });
        return $forms;
    }
    /*
     |--------------------------------------------------------------------------
     | Relationship Methods
     |--------------------------------------------------------------------------
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
    public function media()
    {
        return $this->belongsToMany(Media::class,'media_lesson', 'media_id', 'lesson_id');
    }
    public function forms()
    {
        return $this->belongsToMany(Form::class,'lesson_form', 'form_id', 'lesson_id');
    }
}
