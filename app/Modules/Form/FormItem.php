<?php

namespace App\Modules\Form;

use App\User;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Type;
use Spatie\Tags\HasTags;
use Vinkla\Hashids\Facades\Hashids;

class FormItem extends Model
{
    use HasTags;

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
    const TYPE_FILL_THE_BLANK_DRAG_AND_DROP = 7;
    const TYPE_MEMORIZE_TERM = 20;
    const TYPE_MEMORIZE_TERM_TRANSLATE_A = 21;
    const TYPE_MEMORIZE_MEDIA_IMAGE = 30;
    const TYPE_MEMORIZE_MEDIA_AUDIO = 31;

    const MEMORIZE_LEVELS = [
        1 => 'Elementary',
        2 => 'Intermediate',
        3 => 'Advanced',
        4 => 'Master',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'hash_id';
    }

    public static function getFormItemFillableBlank($itemId)
    {
        $formItem = self::find($itemId);
        if (!empty($formItem)){
            return $formItem->getFillableBlank($formItem->id);
        }
        return null;
    }
    public function getFillableBlank($id = null)
    {
        if (is_null($id))
        {
            $id = $this->id;
        }
        $paragraph = $this->options['paragraph'];
        $search = $replace = '';
        if ($this->type == self::TYPE_FILL_THE_BLANK){
            $search = '#\<tag\>(.+?)\<\/tag\>#s';
            $replace = ' <span class="item-'.$id.'-paragraph-blank"><input class="input-blank" name="item_answer['.$id.'][]" type="text"></span> ';
            return preg_replace($search,$replace,$paragraph);
        } elseif ($this->type == self::TYPE_FILL_THE_BLANK_DRAG_AND_DROP){
            $search = '#\<tagdraggableblank\>(.+?)\<\/tagdraggableblank\>#s';
            $replace = ' <div class="item-'.$id.'-paragraph-blank droppable-blank" ondragover="getHoveredId(this)"></div> ';
            return preg_replace($search,$replace,$paragraph);

        }
//        <input class="input-blank" name="item_answer['.$id.'][]" type="text">
//        $string = "<tag>i dont know what is here</tag>";
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
    public static function getGroupSection($items)
    {
        return $items->where('type', self::TYPE_SECTION)->first();
    }

    public static function getItemsWithShuffleStatus($items)
    {
        // get section
        $section = self::getGroupSection($items);
        $sectionProps =  $section->properties;
        $questionsShuffle = isset($sectionProps['shuffle_questions']) ?  $sectionProps['shuffle_questions'] : 0;
        if ($questionsShuffle == 1){ // 1 is shuffled.
            return $items->shuffle();
        }
        return $items;
    }

    /**
     * @param null $type
     * @return array|mixed
     */
    public function getDefaultAnswers($type = null)
    {
        $answers = array();
        if (!empty($this->options)){
            if (is_null($type)){
                foreach ($this->options as $key => $option){
                    if (isset($option['default']) && $option['default'] == 1){
                        $answers[$option['id']] = [
                            'value' => $option['title'],
                            'score' => $option['mark'],
                        ];
                    }
                }
            } elseif ($type == self::TYPE_FILL_THE_BLANK){
                $answers = !empty($this->options['paragraph_blanks']) ? $this->options['paragraph_blanks'] : array();
            }
        }
        return $answers;
    }

    public static function createOrUpdateMemorize($input, $item = null)
    {
        $owner = getAuthUser();
        $optionsArray = array();
        if (empty($owner)){
            abort(500);
        }
        $input['editor_id'] = $owner->id;
        if (empty($input['item_id'])){
            // error maybe
        }
        foreach ($input['item_id'] as $id){
            $optionsArray[] = [
                'default_title' => !empty($input['item_default_title'][$id]) ? $input['item_default_title'][$id] : '',
                'description' => !empty($input['item_description'][$id]) ? $input['item_description'][$id] : '',
                'lang' => !empty($input['item_lang'][$id]) ? $input['item_lang'][$id] : 'en',
                'status' => !empty($input['item_status'][$id]) ? $input['item_status'][$id] : 0,
            ];
        }
        $propertiesArray = [
            'level' => !empty($input['level']) ? $input['level'] : '',
            'time_to_answer' => !empty($input['time_to_answer']) ? $input['time_to_answer'] : '',
        ];
        $input['options'] = $optionsArray;
        $input['properties'] = $propertiesArray;
        if (is_null($item)){
            $input['type'] = FormItem::TYPE_MEMORIZE;
            $input['creator_id'] = $owner->id;
            $item = FormItem::create($input);
            $item->hash_id = Hashids::encode(1,$owner->id,$item->id);
            $item->save();
        }else{
            $item->update($input);
        }


        // update tags
        $tags =!empty($input['tags']) ? $input['tags'] :  array();
        $item->syncTagsWithType($tags, 'memorize');
        return $item;
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
