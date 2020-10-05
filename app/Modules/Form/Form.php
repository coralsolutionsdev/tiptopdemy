<?php

namespace App\Modules\Form;

use App\Modules\Course\Lesson;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    const TYPE_FORM = 1;
    const TYPE_FORM_TEMPLATE = 2;

    // updating types
    const CREATE_NEW_VERSION = 1;
    const UPDATE_EXISTING_VERSION = 0;

    const OWNER_TYPE_LESSON = 1;
    const OWNER_TYPES_ARRAY = [
        self::OWNER_TYPE_LESSON => 'App\Modules\Course\Lesson'
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

    /**
     * return form items grouped by section
     * @return mixed
     */
    public function getGroupedItems(){
        return $this->items->groupBy('section');
    }

    public static function getOwner($ownerID = null, $ownerType = null)
    {
        if (!key_exists($ownerType, self::OWNER_TYPES_ARRAY)){
            abort('500');
        }
        $model = self::OWNER_TYPES_ARRAY[$ownerType];
        return $model::find($ownerID);

    }
    /**
     * Create and update item
     * @param $input
     * @param $owner
     * @param null $form
     * @return |null
     */
    public static function createOrUpdate($input,$owner = null, $form = null)
    {
        // TODO: update the method to create form without owner
        $iDs = isset($input['item_id'])? $input['item_id'] : array();
        $typeArray = isset($input['item_type']) ? $input['item_type'] : array();
        $existingForm = !empty($form) ? $form : null;
        $updateType = isset($input['update_type']) ? $input['update_type'] : Form::CREATE_NEW_VERSION;
        $section = 0;
        $lastSectionItem = null;
        $currentSectionScore = 0;
        $input['version'] = !empty($existingForm) ? $existingForm->version : 0;
        $input['master_id'] = null;
        $input['status'] = 1;
        $input['creator_id'] = getAuthUser()->id;
        $input['editor_id'] = getAuthUser()->id;
        $ownerId = !empty($owner) ? $owner->id : 0;
        $currentSection = null;
        // form properties
        $properties = [
            'score_type' => isset($input['score_type']) ?  $input['score_type'] : null,
            'passing_score' => isset($input['passing_score']) ?  $input['passing_score'] : null,
            'has_time_limit' => isset($input['has_time_limit']) ?  1 : 0,
            'time_limit' => isset($input['time_limit']) ?  $input['time_limit'] : '',
            'attempts_number' => isset($input['attempts_number']) ?  $input['attempts_number'] : null,
            'shuffle_questions' => isset($input['shuffle_questions']) ?  1 : 0,
            'shuffle_groups' => isset($input['shuffle_groups']) ?  1 : 0,
            'display_type' => isset($input['display_type']) ?  $input['display_type'] : null,
            'direction' => isset($input['direction']) ?  $input['direction'] : null,
            'feedback_correct' => isset($input['feedback_correct']) ?  $input['feedback_correct'] : null,
            'feedback_incorrect' => isset($input['feedback_incorrect']) ?  $input['feedback_incorrect'] : null,
            'feedback_retry' => isset($input['feedback_retry']) ?  $input['feedback_retry'] : null,
            'submission_title' => isset($input['submission_title']) ?  $input['submission_title'] : null,
        ];
        $input['properties'] = $properties;

        $createNew = true;
        if (!is_null($form) && !empty($form)){
            if ($updateType == self::UPDATE_EXISTING_VERSION){
                $createNew = false;
            }else{
                $input['version'] = $existingForm->version+1;
                $input['master_id'] = $existingForm->master_id;
                $input['ancestor_id'] = $existingForm->id;
            }
        }

        if ($createNew == true || empty($form) || is_null($form)){
            $form =  self::create($input);
            $form->slug = Hashids::encode(1,$ownerId,$form->id); // change this
            $form->hash_id = Hashids::encode(1,$ownerId,$form->id);
            $form->save();
            if(!empty($owner)){
                $owner->forms()->attach($form->id);
            }
        }else{
            $form->update($input);
            // destroy removed items
            foreach ($form->items as $item){
                if (!in_array($item->id, $iDs)){
                    $item->delete();
                }
            }
        }

        // update Category
        $categories = isset($input['categories']) ? $input['categories'] : array();
        $form->categories()->sync($categories);

        $sectionItemCount = 0;
        $sectionAllowedQuestionsToAnswer = null;
        foreach ($iDs as $itemPosition => $id){
            $itemType = $typeArray[$id];
            if ($itemType == FormItem::TYPE_SECTION){
                $sectionItemCount = 0;
                $section++;
                $sectionAllowedQuestionsToAnswer = isset($input['item_section_allowed_number'][$id]) ? intval($input['item_section_allowed_number'][$id]) : null;
            }else{
                $sectionItemCount++;
            }
            $newItem = null;
            $newItemOptions = null;
            $newItem['title'] = isset($input['item_title'][$id]) ? $input['item_title'][$id] : '';
            $newItem['description'] = isset($input['item_description'][$id]) ? $input['item_description'][$id] : '';
            $newItem['position'] = $itemPosition;
            $newItem['section'] = $section;
            $newItem['type'] = $itemType;
            $newItem['form_id'] = $form->id;
            $newItem['status'] = 1;
            $newItem['creator_id'] = getAuthUser()->id;
            $newItem['editor_id'] = getAuthUser()->id;
            // properties
            $properties = [ // TODO: update these
                'width' => isset($input['item_width'][$id]) ? $input['item_width'][$id] : null,
                'score' => isset($input['item_score'][$id]) ? $input['item_score'][$id] : 0,
                'source' => isset($input['item_source'][$id]) ? $input['item_source'][$id] : null,
                'placeholder' => isset($input['item_placeholder'][$id]) ? $input['item_placeholder'][$id] : null,
                'difficulty' => isset($input['item_difficulty'][$id]) ? $input['item_difficulty'][$id] : null,
                'display' => isset($input['item_display'][$id]) ? $input['item_display'][$id] : null,
                'answer_time' => isset($input['item_answer_time'][$id]) ? 1 : 0,
                'answer_time_within' => isset($input['item_answer_time_within'][$id]) ? $input['item_answer_time_within'][$id] : null,
                'shuffle_options' => isset($input['item_shuffle_options'][$id]) ? 1 : 0,
                'shuffle_questions' => isset($input['item_shuffle_questions'][$id]) ? 1 : 0,
                'uniform' => isset($input['item_uniform'][$id]) ? 1 : 0,
                'tags' => null,
                'allowed_number' => isset($input['item_section_allowed_number'][$id]) ? intval($input['item_section_allowed_number'][$id]) : null,
                'correction' => isset($input['item_correction'][$id]) ? $input['item_correction'][$id] : 1,

            ];
            $newItem['score'] = isset($input['item_score'][$id]) ? $input['item_score'][$id] : 0;
            $newItem['properties'] = $properties;

            // create new or update  form item
            if ($updateType == self::UPDATE_EXISTING_VERSION){
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
            // update section score
            if ($newFormItem->type == 0){
                $currentSection = $newFormItem;
            }

            if (!empty($currentSection)){
                if (empty($sectionAllowedQuestionsToAnswer) || $sectionAllowedQuestionsToAnswer >= $sectionItemCount){
                    $currentSection->score = $currentSection->score + $newFormItem->score;
                }
            }

            // based on item form
            $multipleOptionsArray = [FormItem::TYPE_SHORT_ANSWER, FormItem::TYPE_SINGLE_CHOICE, FormItem::TYPE_MULTI_CHOICE, FormItem::TYPE_DROP_DOWN];
            if (in_array($itemType, $multipleOptionsArray)){
                if(isset($input['item_option_position']) && array_key_exists($id, $input['item_option_position'])){ // have options
                    $itemOptionsPositions = $input['item_option_position'][$id];
                    $itemOptionsTitles = $input['item_option_title'][$id];
                    $itemOptionsDefault = isset($input['item_option_default']) && !empty($input['item_option_default'][$id])?  $input['item_option_default'][$id] : null;
                    $itemOptionMark = isset($input['item_option_marks']) && !empty($input['item_option_marks'][$id])?  $input['item_option_marks'][$id] : null;
                    foreach ($itemOptionsPositions as $key => $optionID){
                        $newItemOptions[$key] = [
                            // Add score and image
                            'id' => $optionID,
                            'title' => $itemOptionsTitles[$optionID],
                            'default' => !empty($itemOptionsDefault) && !empty($itemOptionsDefault[$optionID]) ? 1 : 0,
                            'mark' => !empty($itemOptionMark) && !empty($itemOptionMark[$optionID]) ? $itemOptionMark[$optionID] : 0

                        ];

                    }
                }
                $newFormItem->options = $newItemOptions;
                $newFormItem->save();
            }elseif ($itemType == FormItem::TYPE_FILL_THE_BLANK){
                $blank = isset($input['item_blanks']) ? $input['item_blanks'][$id] : null;
                $blankOptions = isset($input['item_blank_option']) && isset($input['item_blank_option'][$id]) ? $input['item_blank_option'][$id] : null;
                $blankOptionsMarks = isset($input['item_blank_option_mark']) && isset($input['item_blank_option_mark'][$id]) ? $input['item_blank_option_mark'][$id] : null;
                $blankAlignments = isset($input['item_blank_alignment']) && $input['item_blank_alignment'][$id] ? $input['item_blank_alignment'][$id] : 'auto';
                $optionsArray = array();
                if (!is_null($blankOptions)){
                    foreach ($blankOptions as $key => $optionItems){
                        $optionsArray[] = [
                            'id' => $key,
                            'items' => $optionItems,
                            'marks' => $blankOptionsMarks,
                        ];
                    }
                }
                $newBlank = str_replace("item_blank_option[".$id."]", "item_blank_option[".$newFormItem->id."]", $blank);
                $newBlank2 = str_replace("item_blank_option_mark[".$id."]", "item_blank_option_mark[".$newFormItem->id."]", $newBlank);
                $newItemBlanks = [
                    'id' => $newFormItem->id,
                    'paragraph' => $newBlank2,
                    'paragraph_blanks' => $optionsArray,
                    'alignment' => $blankAlignments
                ];
                $newFormItem->options = $newItemBlanks;
                $newFormItem->save();
            }
            // update section score
            if ($newFormItem->type == FormItem::TYPE_SECTION){
                $lastSectionItem = $newFormItem;
                $currentSectionScore = 0;
            }
            if (!is_null($lastSectionItem)){
                $currentSectionScore = $currentSectionScore  + $newFormItem->score;
                $lastSectionItem->save();
            }
        } // end of foreach
        return $form;
    }
    function clone($input)
    {
        $owner = null;
        if (isset($input['owner_id']) && isset($input['owner_type'])){
            $owner = self::getOwner($input['owner_id'], $input['owner_type']);
        }
        $ownerId = !empty($owner)? $owner->id : 0;
        $newForm = $this->replicate();
        $newForm->push();
        $newForm->slug = Hashids::encode(1,$ownerId,$newForm->id); // change this
        $newForm->hash_id = Hashids::encode(1,$ownerId,$newForm->id);
        $newForm->type = $input['type'];
        $newForm->title = isset($input['title']) ? $input['title'] : $newForm->title;
        $newForm->save();
        if(!empty($owner)){
            $owner->forms()->attach($newForm->id);
        }
        // clone items
        $formItems = $this->items;
        if (!empty($formItems)){
            foreach ($formItems as $item){
                $newFormItem = $item->replicate();
                $newFormItem->push();
                $newFormItem->form_id = $newForm->id;
                if ($newFormItem->type == FormItem::TYPE_FILL_THE_BLANK){
                    $blank = $item->options['paragraph'];
                    $newBlank = str_replace("item_blank_option[".$item->id."]", "item_blank_option[".$newFormItem->id."]", $blank);
                    $newBlank2 = str_replace("item_blank_option_mark[".$item->id."]", "item_blank_option_mark[".$newFormItem->id."]", $newBlank);
                    $newItemBlanks = [
                        'id' => $newFormItem->id,
                        'paragraph' => $newBlank2,
                        'paragraph_blanks' => $item->options['paragraph_blanks'],
                        'alignment' => $item->options['alignment']
                    ];
                    $newFormItem->options = $newItemBlanks;
                }
                $newFormItem->save();
            }
        }
        // update Category
        $categories = isset($input['categories']) ? $input['categories'] : array();
        $newForm->categories()->sync($categories);

        return $newForm;
    }
    public function getDirection()
    {
        $d = $this->properties['direction'];
        switch ($d) {
            case 1:
                return 'ltr';
                break;
            case 2:
                return 'rtl';
             break;
            default:
               return getLanguage() == 'ar'? 'rtl': 'ltr';
        }

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
    /**
     * Many-To-Many Relationship Method for accessing the categories
     *
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
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
