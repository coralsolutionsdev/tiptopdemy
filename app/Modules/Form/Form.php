<?php

namespace App\Modules\Form;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Form extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id',
        'title',
        'description',
        'version',
        'master_id',
        'ancestor_id',
        'submit_route',
        'type',
        'status',
        'position',
        'properties',
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
        'properties' => 'array',
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

    const TYPE_SECTION = 0;
    const TYPE_SHORT_ANSWER = 1;
    const TYPE_PARAGRAPH = 2;
    const TYPE_SINGLE_CHOICE = 3;
    const TYPE_MULTI_CHOICE = 4;
    const TYPE_DROP_DOWN = 5;
    const TYPE_FILL_THE_BLANK = 6;
    // updating types
    const CREATE_NEW_VERSION = 1;
    const UPDATE_EXISTING_VERSION = 0;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'hash_id';
    }

    /**
     * return form items grouped by section
     * @return mixed
     */
    public function getGroupedItems(){
        return $this->items->groupBy('section');
    }

    /**
     * Create and update item
     * @param $input
     * @param $owner
     * @param null $form
     * @return |null
     */
    public static function createOrUpdate($input,$owner, $form = null)
    {
        // TODO: update the method to create form without owner
        $iDs = isset($input['item_id'])? $input['item_id'] : array();
        $typeArray = isset($input['item_type']) ? $input['item_type'] : array();
        $existingForm = !empty($form) ? $form : null;
        $section = 0;
        $input['version'] = !empty($existingForm) ? $existingForm->version : 0;
        $input['master_id'] = null;
        $input['status'] = 1;
        $input['creator_id'] = getAuthUser()->id;
        $input['editor_id'] = getAuthUser()->id;
        $createNew = true;
        if (!is_null($form) && !empty($form)){
            if ($input['update_type'] == self::UPDATE_EXISTING_VERSION){
                $createNew = false;
            }else{
                $input['version'] = $existingForm->version+1;
                $input['master_id'] = $existingForm->master_id;
                $input['ancestor_id'] = $existingForm->id;
            }

        }

        if ($createNew == true || empty($form) || is_null($form)){
            $form =  self::create($input);
            $form->slug = Hashids::encode(1,$owner->id,$form->id);
            $form->hash_id = Hashids::encode(1,$owner->id,$form->id);
            $form->save();
            $owner->forms()->attach($form->id);
        }else{
            $form->update($input);
            // destroy removed items
            foreach ($form->items as $item){
                if (!in_array($item->id, $iDs)){
                    $item->delete();
                }
            }
        }

        foreach ($iDs as $itemPosition => $id){
            $itemType = $typeArray[$id];
            if ($itemType == Form::TYPE_SECTION){
                $section++;
            }
            $newItem = null;
            $newItemOptions = null;
            $newItem['title'] = $input['item_title'][$id];
            $newItem['description'] = $input['item_description'][$id];
            $newItem['position'] = $itemPosition;
            $newItem['section'] = $section;
            $newItem['type'] = $itemType;
            $newItem['form_id'] = $form->id;
            $newItem['status'] = 1;
            $newItem['creator_id'] = getAuthUser()->id;
            $newItem['editor_id'] = getAuthUser()->id;
            // properties
            $properties = [
                'width' => isset($input['item_width'][$id]) ? $input['item_width'][$id] : null,
                'score' => isset($input['item_score'][$id]) ? $input['item_score'][$id] : null,
                'placeholder' => isset($input['item_placeholder'][$id]) ? $input['item_placeholder'][$id] : null,
                'difficulty' => isset($input['item_difficulty'][$id]) ? $input['item_difficulty'][$id] : null,
                'source' => isset($input['item_source'][$id]) ? $input['item_source'][$id] : null,
                'recommended' => isset($input['item_recommended'][$id]) ? $input['item_recommended'][$id] : null,
                'tags' => null,
            ];
            $newItem['properties'] = $properties;

            // create new or update  form item
            if ($input['update_type'] == self::UPDATE_EXISTING_VERSION){
                $newFormItem =  FormItem::find($id);
                if (!empty($newFormItem)){
                    $newFormItem->update($newItem);
                }else{
                    $newFormItem =  FormItem::create($newItem);
                    $newFormItem->hash_id = Hashids::encode(1,$form->id,$newFormItem->id);
                    $newFormItem->save();
                }
            }else{
                $newFormItem =  FormItem::create($newItem);
                $newFormItem->hash_id = Hashids::encode(1,$form->id,$newFormItem->id);
                $newFormItem->save();
            }


            // based on item form
            if ($itemType == FormItem::TYPE_SINGLE_CHOICE || $itemType == FormItem::TYPE_MULTI_CHOICE || $itemType == FormItem::TYPE_DROP_DOWN){
                if(isset($input['item_option_position']) && array_key_exists($id, $input['item_option_position'])){ // have options
                    $itemOptionsPositions = $input['item_option_position'][$id];
                    $itemOptionsTitles = $input['item_option_title'][$id];
                    $itemOptionsDefault = isset($input['item_option_default']) && !empty($input['item_option_default'][$id])?  $input['item_option_default'][$id] : null;
                    foreach ($itemOptionsPositions as $key => $optionID){
                        $newItemOptions[$key] = [
                            'id' => $optionID,
                            'title' => $itemOptionsTitles[$optionID],
                            'default' => !empty($itemOptionsDefault) && !empty($itemOptionsDefault[$optionID]) ? 1 : 0
                        ];

                    }
                }
                $newFormItem->options = $newItemOptions;
                $newFormItem->save();
            }elseif ($itemType == FormItem::TYPE_FILL_THE_BLANK){
                $blank = isset($input['item_blanks']) ? $input['item_blanks'][$id] : null;
                $blankOptions = isset($input['item_blank_option'])? $input['item_blank_option'][$id] : null;
                $optionsArray = array();
                if (!is_null($blankOptions)){
                    foreach ($blankOptions as $key => $optionItems){
                        $optionsArray[] = [
                            'id' => $key,
                            'items' => $optionItems
                        ];
                    }
                }
                $newBlank = str_replace("item_blank_option[".$id."]", "item_blank_option[".$newFormItem->id."]", $blank);
                $newItemBlanks = [
                    'id' => $newFormItem->id,
                    'paragraph' => $newBlank,
                    'paragraph_blanks' => $optionsArray,

                ];
                $newFormItem->options = $newItemBlanks;
                $newFormItem->save();
            }

        }
        return $form;
    }

    /*
     |--------------------------------------------------------------------------
     | Relationship Methods
     |--------------------------------------------------------------------------
     */
    public function master()
    {
        return $this->belongsTo(Form::class);
    }

    public function ancestor()
    {
        return $this->belongsTo(Form::class);
    }
    public function children()
    {
        return $this->hasMany(Form::class, 'ancestor_id');
    }

    public function items(){
        return $this->hasMany(FormItem::class)->orderBy('position');
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
