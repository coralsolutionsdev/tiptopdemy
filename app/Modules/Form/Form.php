<?php

namespace App\Modules\Form;

use App\Modules\Course\Lesson;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Tags\HasTags;
use Vinkla\Hashids\Facades\Hashids;

class Form extends Model
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
    const TYPE_MEMORIZE = 3;
    const TYPE_MEMORIZE_TEMPLATE = 4;

    // updating types
    const CREATE_NEW_VERSION = 1;
    const UPDATE_EXISTING_VERSION = 0;

    const OWNER_TYPE_LESSON = 1;
    const OWNER_TYPES_ARRAY = [
        self::OWNER_TYPE_LESSON => 'App\Modules\Course\Lesson'
    ];

    const MEMORIZE_LEVELS = [
        1 => 'Elementary',
        2 => 'Intermediate',
        3 => 'Advanced',
        4 => 'Master',
    ];

    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 2;
    const STATUS_DISABLED = 3;

    const STATUS_ARRAY = [
        self::STATUS_PUBLISHED => 'Published',
        self::STATUS_UNPUBLISHED => 'Unpublished',
        self::STATUS_DISABLED => 'Disabled',
    ];
    /*tiptop taxonomy types*/
    const TAXONOMY_TYPE_CREATE = 1;
    const TAXONOMY_TYPE_EVALUATE = 2;
    const TAXONOMY_TYPE_ANALYZE = 3;
    const TAXONOMY_TYPE_APPLY = 4;
    const TAXONOMY_TYPE_UNDERSTAND = 5;
    const TAXONOMY_TYPE_REMEMBER = 6;

    const TAXONOMY_TYPES_ARRAY = [
        self::TAXONOMY_TYPE_CREATE => 'Create',
        self::TAXONOMY_TYPE_EVALUATE => 'Evaluate',
        self::TAXONOMY_TYPE_ANALYZE => 'Analyze',
        self::TAXONOMY_TYPE_APPLY => 'Apply',
        self::TAXONOMY_TYPE_UNDERSTAND => 'Understand',
        self::TAXONOMY_TYPE_REMEMBER => 'Remember',
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
        $input['status'] = isset($input['status']) ? $input['status'] : 1;
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
            $tags = isset($input['item_taxonomy_b'][$id]) ? $input['item_taxonomy_b'][$id] : array();
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
                'tags' => $tags,
                'allowed_number' => isset($input['item_section_allowed_number'][$id]) ? intval($input['item_section_allowed_number'][$id]) : null,
                'evaluation' => isset($input['item_evaluation'][$id]) ? $input['item_evaluation'][$id] : 1,
                'taxonomies_a' => isset($input['item_taxonomy'][$id]) ? $input['item_taxonomy'][$id] : array(),
                'extra_blanks' => isset($input['item_extra_blanks'][$id]) ? $input['item_extra_blanks'][$id] : array(),
                'similarity_code' => isset($input['item_similarity_code'][$id]) ? $input['item_similarity_code'][$id] : null,
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
            }elseif ($itemType == FormItem::TYPE_FILL_THE_BLANK || $itemType == FormItem::TYPE_FILL_THE_BLANK_DRAG_AND_DROP || $itemType == FormItem::TYPE_FILL_THE_BLANK_RE_ARRANGE){
                $blank = isset($input['item_blanks']) ? $input['item_blanks'][$id] : null;
                $blankOptions = isset($input['item_blank_option']) && isset($input['item_blank_option'][$id]) ? $input['item_blank_option'][$id] : null;
                $blankOptionsMarks = isset($input['item_blank_option_mark']) && isset($input['item_blank_option_mark'][$id]) ? $input['item_blank_option_mark'][$id] : null;
//                $blankTypes = isset($input['item_blank_type']) && isset($input['item_blank_type'][$id]) ? $input['item_blank_type'][$id] : null;
                $blankAlignments = isset($input['item_blank_alignment']) && $input['item_blank_alignment'][$id] ? $input['item_blank_alignment'][$id] : 'auto';
                $optionsArray = array();
                if (!is_null($blankOptions)){
                    foreach ($blankOptions as $key => $optionItems){
                        $itemsArray = array();
                        foreach ($optionItems as $itemKey => $itemValue){
                            $itemsArray[$itemKey] = [
                                'value' => $itemValue,
                                'score' => $blankOptionsMarks[$key][$itemKey],
//                                'type' => $blankTypes[$key] ? $blankTypes[$key][$itemKey] : 1,
                            ];
                        }
                        $optionsArray[] = [
                            'id' => $key,
                            'items' => $itemsArray,
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
            // update tags
            $newFormItem->syncTagsWithType($tags, 'form_taxonomy');
        } // end of foreach
        return $form;
    }

    /**
     * @param $input
     * @return Form
     */
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
                if ($newFormItem->type == FormItem::TYPE_FILL_THE_BLANK || $newFormItem->type == FormItem::TYPE_FILL_THE_BLANK_DRAG_AND_DROP || $newFormItem->type == FormItem::TYPE_FILL_THE_BLANK_RE_ARRANGE){
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
                // update tags
                $tags = !empty($newFormItem['properties']['properties']) ? $newFormItem['properties']['properties'] : array();
                $newFormItem->syncTagsWithType($tags, 'form_taxonomy');
            }
        }
        // update Category
        $categories = isset($input['categories']) ? $input['categories'] : array();
        $newForm->categories()->sync($categories);

        return $newForm;
    }

    /**
     * @param $input
     * @param null $owner
     * @param null $form
     * @return mixed
     */

    public static function createOrUpdateWithType($input,$owner = null, $form = null){
        $user = getAuthUser();
        if (!$user){
            abort(500);
        }
        $existingForm = !empty($form) ? $form : null;
        $input['version'] = !empty($existingForm) ? $existingForm->version : 0;
        $input['master_id'] = null;
        $input['status'] = isset($input['status']) ? $input['status'] : 0;
        $input['editor_id'] = $user->id;
        $input['properties'] = [
            'item_question' => isset($input['item_question']) ? $input['item_question'] : '',
            'level' => isset($input['level']) ? $input['level'] : 1,
            'time_to_answer' => isset($input['time_to_answer']) ? $input['time_to_answer'] : 1,
            'type_titles' => [
                FormItem::TYPE_MEMORIZE_TERM => isset($input['form_item_type_title']) && isset($input['form_item_type_title'][FormItem::TYPE_MEMORIZE_TERM]) ? $input['form_item_type_title'][FormItem::TYPE_MEMORIZE_TERM] : 'Terms group',
                FormItem::TYPE_MEMORIZE_TERM_TRANSLATE_A => isset($input['form_item_type_title']) && isset($input['form_item_type_title'][FormItem::TYPE_MEMORIZE_TERM_TRANSLATE_A]) ? $input['form_item_type_title'][FormItem::TYPE_MEMORIZE_TERM_TRANSLATE_A] : 'Translations group',
            ],
            'type_statuses' => isset($input['form_item_type_status']) ? $input['form_item_type_status'] : null
        ];
        $ownerId = !empty($owner) ? $owner->id : 0;
        $typesArray = isset($input['item_type']) ? $input['item_type'] : null;
        if (empty($form)){
            $input['creator_id'] = $user->id;
            $form = Form::create($input);
            $form->slug = Hashids::encode($user->getTenancyId(),$ownerId,$form->id); // change this
            $form->hash_id = Hashids::encode($user->getTenancyId(),$ownerId,$form->id);
            $form->save();
            if(!empty($owner)){
                $owner->forms()->attach($form->id);
            }
        }else{
            $form->update($input);
        }

        // update tags
        $tags =!empty($input['tags']) ? $input['tags'] :  array();
        $form->syncTagsWithType($tags, 'memorize');


        // deleted items
        if (isset($input['deleted_items']) && !empty($input['deleted_items'])){
            foreach ($input['deleted_items'] as $deleted_item_id) {
                $deletedItem = FormItem::find($deleted_item_id);
                if ($deletedItem = FormItem::find($deleted_item_id)){
                    $deletedItem->delete();
                }
            }
        }

        // create or update items
        if (!empty($typesArray)){
            foreach ($typesArray as $id => $type){
                $formItemInput['title'] = isset($input['item_title']) && isset($input['item_title'][$id]) ? $input['item_title'][$id] : '';
                $formItemInput['status'] = isset($input['item_status']) && isset($input['item_status'][$id]) ? $input['item_status'][$id] : 0;
                $formItemInput['type'] = $type;
                $formItemInput['form_id'] = $form->id;
                $formItemInput['creator_id'] = $user->id;
                $formItemInput['editor_id'] = $user->id;
                $formItemInput['properties']  = [
                    'media_url' => isset($input['item_media_url']) && isset($input['item_media_url'][$id]) ? $input['item_media_url'][$id] : '',
                ];

                $formItem = FormItem::find($id);
                if (empty($formItem)){
                    $newFormItem = FormItem::create($formItemInput);
                    $newFormItem->hash_id = Hashids::encode($user->getTenancyId(),$form->id,$newFormItem->id);
                    $newFormItem->save();
                }else{
                    $formItem->update($formItemInput);
                }

            }
        }
        return $form;
    }



    public function createResponse($answers)
    {
        $items = $this->items;
        $inputLeaveQuestions = array();
        // default values
        $user = getAuthUser();
        $section = 0;
        $newItemInput['status'] = FormResponse::STATUS_FULLY_EVALUATED;
        $sectionEvaluationTypeArray[0] = FormResponse::EVALUATION_TYPE_AUTO;
        $responseTotalScore = 0;
        $responseAchievedTotalScore = 0;
        $data =  array();

        if (!empty($items)){
            foreach ($items as $formItem){
                $item = null;
                // get item answers
                foreach ($answers as $answerArray){
                    if ($answerArray['id'] == $formItem->id){
                        $item = $answerArray;
                    }
                }
                $itemInputAnswer = !empty($item) && !empty($item['answers']) ? $item['answers'] : null;
                $answeringStatus = !empty($item) && !empty($item['answer_status']) && $item['answer_status'] == 1;
                $itemAnswersArray = array(); // default as empty
                $ItemTotalAnswerScore = 0;
                $itemDefaultAnswers = $formItem->getDefaultAnswers();


                $itemType = $formItem->type;
                if ($itemType == FormItem::TYPE_SECTION){ // section
                    $section++;
                    $sectionEvaluationTypeArray[$section] = FormResponse::EVALUATION_TYPE_AUTO; // default auto evaluation
                    if (!empty($formItem->properties['evaluation']) && $formItem->properties['evaluation'] == FormResponse::EVALUATION_TYPE_MANUAL){
                        $newItemInput['status'] = FormResponse::STATUS_PARTIALLY_EVALUATED;
                        // answers array is empty
                        $sectionEvaluationTypeArray[$section] = FormResponse::EVALUATION_TYPE_MANUAL;
                    }
                } else { // not section

                    if ($answeringStatus){ // answered

                        $responseTotalScore = $responseTotalScore + $formItem->score;
                        if ($itemType ==  FormItem::TYPE_PARAGRAPH){
                            $newItemInput['status'] = FormResponse::STATUS_PARTIALLY_EVALUATED;
                        } elseif (in_array($itemType, [FormItem::TYPE_SHORT_ANSWER, FormItem::TYPE_SINGLE_CHOICE, FormItem::TYPE_DROP_DOWN, FormItem::TYPE_MULTI_CHOICE])) {

                            if (!empty($itemInputAnswer)){ // check if item have answers
                                // evaluation
                                if (!is_array($itemInputAnswer)){
                                    $itemInputAnswerArray = [$itemInputAnswer];
                                }else{
                                    $itemInputAnswerArray = $itemInputAnswer;
                                }
                                foreach ($itemInputAnswerArray as $itemInputAnswerValue){
                                    $ItemAnswerScore = 0;
                                    $itemAnswerStatus = FormResponse::EVALUATION_STATUS_PENDING; // evaluation status correct
                                    if ($sectionEvaluationTypeArray[$section] == FormResponse::EVALUATION_TYPE_AUTO){ // check if evaluation is auto
                                        $itemAnswerStatus = FormResponse::EVALUATION_STATUS_WRONG; // default evaluation status
                                        if (!empty($itemDefaultAnswers)){ // have default answers
                                            foreach ($itemDefaultAnswers as $defaultAnswer){
                                                $valueToLower = strtolower($defaultAnswer['value']);
                                                $defaultAnswerToLower = strtolower($itemInputAnswerValue);
                                                if ($valueToLower == $defaultAnswerToLower){
                                                    $itemAnswerStatus = FormResponse::EVALUATION_STATUS_CORRECT; // evaluation status correct
                                                    $ItemAnswerScore = $defaultAnswer['score']; // evaluation score
                                                    $ItemTotalAnswerScore = $ItemTotalAnswerScore + $ItemAnswerScore; // evaluation score
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    // answers array (add to answer array)
                                    $itemAnswersArray[] = [
                                        'value' => $itemInputAnswerValue,
                                        'status' => $itemAnswerStatus,
                                        'score' => $ItemAnswerScore,
                                    ];

                                }


                            }

                        } elseif (in_array($itemType, [FormItem::TYPE_FILL_THE_BLANK, FormItem::TYPE_FILL_THE_BLANK_DRAG_AND_DROP, FormItem::TYPE_FILL_THE_BLANK_RE_ARRANGE])){

                            if (!empty($itemInputAnswer)){ // check if item have answers
                                $itemScore = $formItem->score; // default evaluation score
                                $defaultAnswers = $formItem->getDefaultAnswers(FormItem::TYPE_FILL_THE_BLANK);
                                // item answers
                                // evaluation
                                if (!is_array($itemInputAnswer)){
                                    $itemInputAnswerArray = [$itemInputAnswer];
                                }else{
                                    $itemInputAnswerArray = $itemInputAnswer;
                                }
                                foreach ($itemInputAnswerArray as $answerKey => $itemInputAnswerValue){
                                    $ItemAnswerScore = 0;
                                    $itemAnswerStatus = FormResponse::EVALUATION_STATUS_PENDING; // evaluation status correct
                                    if ($sectionEvaluationTypeArray[$section] == FormResponse::EVALUATION_TYPE_AUTO){ // check if evaluation is auto
                                        $itemAnswerStatus = FormResponse::EVALUATION_STATUS_WRONG; // evaluation status correct
                                        if (!empty($defaultAnswers)){ // have default answers
                                            if (!empty($defaultAnswers[$answerKey])){
                                                $blankItems = $defaultAnswers[$answerKey]['items'];
                                                foreach ($blankItems as $blankItem){
                                                    $itemInputAnswerValueToLower = strtolower($itemInputAnswerValue);
                                                    $blankItemValueToLower = strtolower($blankItem['value']);
                                                    if ($itemInputAnswerValueToLower == $blankItemValueToLower){
                                                        $itemAnswerStatus = FormResponse::EVALUATION_STATUS_CORRECT; // evaluation status correct
                                                        $ItemAnswerScore = $blankItem['score']; // evaluation score
                                                        $ItemTotalAnswerScore = $ItemTotalAnswerScore + $ItemAnswerScore; // evaluation score
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    // answers array (add to answer array)
                                    $itemAnswersArray[] = [
                                        'value' => $itemInputAnswerValue,
                                        'status' => $itemAnswerStatus,
                                        'score' => $ItemAnswerScore,
                                    ];

                                }
                            }
                        }

                    }


                }
                //
                // update total achieved score
                $responseAchievedTotalScore = $responseAchievedTotalScore + $ItemTotalAnswerScore;
                // add to data array
                $data[$section][] = [
                    'id' => $formItem->id,
                    'title' => $formItem->title,
                    'description' => $formItem->description,
                    'answers' => $itemAnswersArray,
                    'type' => $formItem->type,
                    'score' => $formItem->score,
                    'evaluation_score' => $ItemTotalAnswerScore,
                    'properties' => $formItem->properties,
                ];

            }
        }

        // response score info
        $scorePercentage = ($responseAchievedTotalScore/$responseTotalScore) * 100;
        $scoringType = !empty($form->properties['score_type']) ? $form->properties['score_type'] : 1;
        $passingScore = !empty($form->properties['passing_score']) ? $form->properties['passing_score'] : 50;
        $scoreStatus = FormResponse::PASSING_STATUS_FAILED; // failed
        if ($scoringType == 1){ //percentage
            if ($scorePercentage >= $passingScore){
                $scoreStatus = FormResponse::PASSING_STATUS_PASSED;
            }
        } elseif ($scoringType == 2) { //score
            if ($responseAchievedTotalScore >= $passingScore){
                $scoreStatus = FormResponse::PASSING_STATUS_PASSED;
            }
        }
        $scoreInfo = [
            'total_score' => $responseTotalScore,
            'achieved_score' => $responseAchievedTotalScore,
            'score_percentage' => round($scorePercentage,1),
            'passing_score_status' => $scoreStatus,
            'passing_score_type' => $scoringType,
            'passing_score_score' => $passingScore,
        ];
        //
        $newItemInput['title'] = $this->title;
        $newItemInput['description'] = $this->description;
        $newItemInput['form_id'] = $this->id;
        $newItemInput['ancestor_id'] = $this->ancestor_id;
        $newItemInput['data'] = $data;
        $newItemInput['type'] = 1; // default Unknown
        $newItemInput['properties'] = $this->properties;
        $newItemInput['score_info'] = $scoreInfo;
        $newItemInput['creator_id'] = getAuthUser() ? getAuthUser()->id : null;
        $response = FormResponse::create($newItemInput);
        $response->hash_id = Hashids::encode(1,$user->id,$response->id);
        $response->save();
        return $response;
    }
    /**
     * @return string
     */
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

    public function getLastResponse()
    {
        $user = getAuthUser();
        if ($user && $resp =  $this->responses()->where('creator_id', $user->id)->latest()->first()){
            return $resp;   
        }
        return null;
    }
    /**
     * Get the array list of this product tags
     * @return array
     */
    public function getTags(): array
    {
        $spatie_tags = $this->tagsWithType('memorize');
        $tags = array();
        foreach($spatie_tags as $tag) {
            $tags[$tag->name] = $tag->name;
        }
        return $tags;
    }
    public function isGroupTypeEnabled($type)
    {
        $formProperties = $this->properties;
        if (!empty($formProperties)){
            if (empty($formProperties['type_statuses'])){
                return true;
            }elseif (!empty($formProperties['type_statuses'][$type])){
                return true;
            }
        }
        return false;
    }


    /**
     * @return mixed|null
     */
    public function getLesson(){
        return $this->lesson();
    }

    /**
     * @return mixed|null
     */
    public function getUnit(){
        $lesson = $this->getLesson();
        return !empty($lesson) ? $lesson->groups->first() : null;
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
    public function responses()
    {
        return $this->hasMany(FormResponse::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
    public function lesson()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_form', 'lesson_id', 'form_id')->first();
    }
}
