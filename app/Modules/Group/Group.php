<?php

namespace App\Modules\Group;

use App\Modules\ColorPattern\ColorPattern;
use App\Modules\Course\Lesson;
use App\Modules\Media\Media;
use App\Modules\modelTrail;
use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use modelTrail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id',
        'title',
        'slug',
        'description',
        'ancestor_id',
        'position',
        'type',
        'owner_type',
        'owner_id',
        'color_id',
        'status',
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
        'ancestor_id' => 'integer',
        'owner_id' => 'integer',
        'color_id' => 'integer',
        'status' => 'integer',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
    ];

    const TYPE_FILE_MANAGER = 1;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function deleteWithDependencies()
    {
        $this->items->each(function ($item) {
            $item->deleteWithDependencies();
        });
        $this->delete();
    }

    /**
     * check if group has item
     * @param $itemId
     * @return mixed
     */
    public function hasItem($itemId){
        return $this->items->where('id', $itemId)->first();
    }




    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }
    public function mediaItems()
    {
        return $this->belongsToMany(Media::class,'group_item','group_id', 'model_id')->withPivot('model_id','model_type');
    }
    public function getLessons()
    {
        return $this->belongsToMany(Lesson::class)->orderBy('position');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function ancestor()
    {
        return $this->belongsTo(Group::class);
    }

    public function owner()
    {
//        return $this->belongsTo(Owner::class);
    }

    public function color()
    {
        return $this->hasOne(ColorPattern::class);
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
