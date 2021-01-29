<?php

namespace App\Modules\Course;

use App\Modules\Form\Form;
use App\Modules\Group\Group;
use App\Modules\Media\Media;
use App\Modules\modelTrail;
use App\Product;
use App\User;
use Bnb\Laravel\Attachments\HasAttachment;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Vinkla\Hashids\Facades\Hashids;

class Lesson extends Model implements ReactableContract, HasMedia
{
    use Reactable;
    use HasMediaTrait;
    use HasAttachment;
    use modelTrail;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'type',
        'product_id',
        'unit_id',
        'status',
        'resources',
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
        'resources' => 'array',
        'content' => 'array',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
    ];

    const TYPE_PRESENTATION = 1;
    const TYPE_QUIZ = 2;

    const TYPES_ARRAY = [
        self::TYPE_PRESENTATION => 'Presentation',
        self::TYPE_QUIZ => 'Quiz',
    ];

    const RESOURCES_TYPE_YOUTUBE_VIDEO = 1;
    const RESOURCES_TYPE_HTML_PAGE = 2;
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
        $mediaType = Media::TYPE_VIDEO;
        $this->clearMediaCollection(Media::getGroup($mediaType));
        $this->delete();
    }

    /**
     * return latest version of each form item
     * @return mixed
     */
    public function getAvailableForms()
    {
        $forms = collect();
        if (!empty($this->getFormsWithType(Form::TYPE_FORM))){
            $forms = $this->getFormsWithType(Form::TYPE_FORM)->where('status', Form::STATUS_PUBLISHED)->filter(function ($form) {
                if ($form->children->count() == 0){
                    return true;
                }
                return false;
            });
        }
        return $forms;

    }

    /**
     * return lesson resources array
     * @return mixed
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     *  create or update item
     * @param $input
     * @param null $lesson
     * @return |null
     */
    public static function createOrUpdate($input, $lesson = null)
    {
        $user = getAuthUser();
        if (empty($user)){
            // error
        }
        $input['creator_id'] = $user->id;
        if (!empty($lesson)){
            $input['editor_id'] = $user->id;
        }
        $input['status'] = isset($input['status']) && !empty($input['status']) ? 1 : 0;

        if (!empty($lesson)){
            $lesson->update($input);
        }else{
            $lesson = self::create($input);
            $lesson->slug = Hashids::encode($user->getTenancyId(),$input['product_id'],$lesson->id);
            $lesson->save();
        }

        // update Category
        $groups = !empty($input['groups']) ? $input['groups'] : array();
        $lesson->groups()->sync($groups);

        // update tags
//        $tags = $request->input('tags', array());
//        $lesson->syncTagsWithType($tags, 'lesson');

        // attachments
        if (isset($input['attachments'])){
            $attachments = $input['attachments'];
            foreach ($attachments as $attachment){
                $lesson->attach($attachment);
            }
        }

        // remove resources
        $removedResources = isset($input['removed-resources']) ? $input['removed-resources'] : null;
        if (!empty($removedResources)){
            foreach ($removedResources as $key => $removedId){
                foreach ($lesson->resources as $lessonResource){
                    if ($lessonResource['id'] == $removedId){
                        if ($lessonResource['type'] == Media::TYPE_VIDEO){
                            $media = $lesson->getMedia(Media::getGroup($lessonResource['type']))->where('id', $removedId)->first();
                            if ($media){
                                $media->delete();
                            }
                        }
                    }
                }
            }
        }
        $resources = array();
        // re arrange resources
        $resourcesId = isset($input['resourceId']) ? $input['resourceId'] : null;
        if (!empty($resourcesId) && !empty($lesson->resources)){
            foreach ($resourcesId as $key => $id){
                foreach ($lesson->resources as $lessonResource){
                    if ($lessonResource['id'] == $id){
                        $resources[] = [
                            'id' => $id,
                            'url' => $lessonResource['url'],
                            'name' => $lessonResource['name'],
                            'type' => $lessonResource['type'],
                        ];
                    }
                }
            }
        }else{
            $mediaType = Media::TYPE_VIDEO;
            $lesson->clearMediaCollection(Media::getGroup($mediaType));
        }

        $lesson->resources = $resources;
        $lesson->save();

        return $lesson;
    }
    public function getFormsWithType($type = null){
        if (!empty($type)){
            if (!empty($this->forms)){
                return $this->forms->where('type', $type);
            }
            return collect();
        }
        return $this->forms;
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
    public function forms()
    {
        return $this->belongsToMany(Form::class,'lesson_form', 'form_id', 'lesson_id');
    }
}
