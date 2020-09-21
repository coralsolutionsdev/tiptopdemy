<?php

namespace App\Modules\Group;

use App\Modules\ColorPattern\ColorPattern;
use App\Modules\Course\Lesson;
use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
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


    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }
    public function items()
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
