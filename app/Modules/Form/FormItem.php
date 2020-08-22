<?php

namespace App\Modules\Form;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FormItem extends Model
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
        'position',
        'section',
        'type',
        'form_id',
        'status',
        'classes',
        'placeholder',
        'score',
        'options',
        'properties',
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
        'status' => 'integer',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
        'options' => 'array',
        'properties' => 'array',
    ];

    const TYPE_SECTION = 0;
    const TYPE_SHORT_ANSWER = 1;
    const TYPE_PARAGRAPH = 2;
    const TYPE_SINGLE_CHOICE = 3;
    const TYPE_MULTI_CHOICE = 4;
    const TYPE_DROP_DOWN = 5;
    const TYPE_FILL_THE_BLANK = 6;

    public function getFillableBlank()
    {
        $paragraph = $this->options['paragraph'];
        $search = '#\<tag\>(.+?)\<\/tag\>#s';
        $replace = ' <input class="input-blank" type="text"> ';
        $string = "<tag>i dont know what is here</tag>";
        $fillable  = preg_replace($search,$replace,$paragraph);

        return $fillable;
    }

    public function getWidth()
    {
        return !empty($this->getPropertiesValue('width')) ? $this->getPropertiesValue('width'): '1-1';
    }

    public function getPropertiesValue($key){
        $value = null;
        $properties = $this->properties;
        if ($properties){
            $value = !empty($properties[$key]) ? $properties[$key]: null;
        }
        return $value;
    }

    /**
     * return tooltip string to view the question description
     * @return string
     */
    function getToolTip()
    {
        $tooltip = '';
        if ($this->type != self::TYPE_SECTION && !empty($this->description)){
            $direction = $this->form->getDirection() == 'ltr' ? 'left' : 'right';
            $tooltip = 'uk-tooltip="title: '.$this->description.'; pos: '.$direction.'"';

        }
        return $tooltip;
    }


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
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
