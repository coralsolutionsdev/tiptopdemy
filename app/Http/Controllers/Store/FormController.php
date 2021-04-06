<?php

namespace App\Http\Controllers\Store;

use App\Category;
use App\Http\Controllers\Controller;
use App\Modules\Course\Lesson;
use App\Modules\Form\Form;
use App\Modules\Form\FormItem;
use App\Modules\Group\Group;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Vinkla\Hashids\Facades\Hashids;

class FormController extends Controller
{
    protected $modelName;
    protected $page_title;
    protected $breadcrumb;

    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['show']]);
        $this->page_title = 'Lesson quiz';
        $this->modelName = 'Store';
        $this->breadcrumb = [
            'lesson' => '',
            'quiz' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Lesson $lesson
     * @return Response
     */
    public function create(Lesson $lesson)
    {
        $page_title =  'Forms Templates';
        $breadcrumb =  $this->breadcrumb;
        $product =  $lesson->product;
        $ownerId = $lesson->id;
        $ownerType = Form::OWNER_TYPE_LESSON;
        return view('store.forms.create', compact('page_title', 'breadcrumb', 'product', 'lesson', 'ownerId', 'ownerId', 'ownerType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Lesson $lesson
     * @return void
     */
    public function store(Request $request, Lesson $lesson)
    {
        $input =  $request->all();
        $input['type'] = Form::TYPE_FORM;
        $form = Form::createOrUpdate($input,$lesson);
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('store.form.edit', [$lesson->slug, $form->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Lesson $lesson, Form $form)
    {
        $page_title =  $form->title;
        $product = $lesson->product;
        $modelName = $this->modelName;
        $breadcrumb =  Breadcrumbs::render('store.product.lesson.quiz', $lesson, $form);
        $prevLessonLink = null;
        $nextLessonLink = null;
        $group = $lesson->groups->first();
        foreach ($group->getLessons as $itemKey => $lessonItem){
            if ($lessonItem->id == $lesson->id){
                $preItem = !empty($group->getLessons[$itemKey-1]) ? $group->getLessons[$itemKey-1] : null;
                $nextItem = !empty($group->getLessons[$itemKey+1]) ? $group->getLessons[$itemKey+1] : null;

            }
        }
        if (!empty($preItem)){
            $prevLessonLink = route('store.lesson.show', [$product->slug, $preItem->slug]);
        }
        if (!empty($nextItem)){
            $nextLessonLink = route('store.lesson.show', [$product->slug, $nextItem->slug]);
        }
        $displayType = !is_null($form->properties['display_type']) ? $form->properties['display_type'] : 1;
        $hasTimeLimit = !empty($form->properties['has_time_limit']) ? $form->properties['has_time_limit'] : 0;
        $timeLimit = !empty($form->properties['time_limit'])? $form->properties['time_limit'] : null;
        $backUrl = route('store.lesson.show', [$product->slug, $lesson->slug]);
        return view('store.forms.frontend.v2.show', compact('modelName', 'product','page_title','breadcrumb', 'lesson', 'prevLessonLink', 'nextLessonLink', 'form', 'displayType', 'hasTimeLimit', 'timeLimit', 'backUrl'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Lesson $lesson
     * @param Form $form
     * @return Response
     */
    public function edit(Lesson $lesson, Form $form)
    {
        $page_title = $form->title;
        $product =  $lesson->product;
        $categories = Category::where('type', Category::TYPE_FORM_TEMPLATE)->where('parent_id', 0)->get();
        $formProperties = $form->properties;
        return view('store.forms.create', compact('page_title', 'product', 'lesson', 'form', 'categories', 'formProperties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Lesson $lesson
     * @param Form $form
     * @return void
     */
    public function update(Request $request, Lesson $lesson, Form $form)
    {
        $input =  $request->all();
        $product =  $lesson->product;
        $input['type'] = Form::TYPE_FORM;
        $form = Form::createOrUpdate($input,$lesson, $form);
        session()->flash('success', trans('main._update_msg'));
        return redirect()->route('store.lessons.edit', [$product->slug, $lesson->slug]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lesson $lesson
     * @param Form $form
     * @return Response
     * @throws \Exception
     */
    public function destroy(Lesson $lesson, Form $form)
    {
        if ($form){
            foreach ($form->items as $item){
                $item->delete();
            }
            $form->delete();
        }
        session()->flash('success', trans('main._delete_msg'));
        return redirect()->back();

    }

    /**
     * @param Lesson $lesson
     * @param Form $form
     * @return Application|ResponseFactory|Response
     */
    function getItems(Lesson $lesson, Form $form){
        $items = $form->items;
        return response($items, 200);
    }

    function templateIndex(Request $request, Lesson $lesson){
        $page_title =  'Quiz Templates';
        $breadcrumb =  $this->breadcrumb;
        $input = $request->only('categories');
        $inputCategories = isset($input['categories'])? $input['categories'] : array();
        $selectedCategories = Category::whereIn('id', $inputCategories)->pluck('id', 'id')->toArray();
        if(!empty($inputCategories)){
            $templates = Form::where('type', Form::TYPE_FORM_TEMPLATE)->get()->filter(function ($temp) use($selectedCategories){
                $cats = $temp->categories;
                $result = false;
                foreach ($cats as $cat){
                    if (in_array($cat->id, $selectedCategories)){
                        $result = true;
                        break;
                    }
                }
                return $result;
            });
        }else{
            $templates = Form::where('type', Form::TYPE_FORM_TEMPLATE)->get()->take(12);
        }
        $categories = Category::where('type', Category::TYPE_FORM_TEMPLATE)->where('parent_id', 0)->get();
        return view('store.lessons.templates.index', compact('page_title', 'breadcrumb', 'lesson', 'categories', 'selectedCategories', 'templates'));
    }

    function smartCreate(Lesson $lesson){
        $page_title =  'Smart form';
        $product = $lesson->product;
        $productGroups = $product->groups;
        $lessonUnit = $lesson->groups->first();
        $unitNumber = getCollectionIndexOfId($productGroups, $lessonUnit)+1;
        $lessonNumber = getCollectionIndexOfId($lessonUnit->getLessons, $lesson)+1;
        return view('forms.smart.create', compact('page_title', 'breadcrumb', 'lesson', 'unitNumber', 'lessonNumber'));
    }

    function smartGetItems(Request $request, Lesson $lesson){
        $input = $request->all();
        $product = $lesson->product;
        $productGroups = $product->groups;
        $lessonUnit = $lesson->groups->first();
        $currentUnitKey = getCollectionIndexOfId($productGroups, $lessonUnit);
        $currentLessonKey = getCollectionIndexOfId($lessonUnit->getLessons, $lesson);
        $selectedUnitKey = isset($input['unit_num']) && !empty($input['unit_num']) ? $input['unit_num']-1 : null;
        $selectedLessonKey = isset($input['lesson_num']) && !empty($input['lesson_num']) ? $input['lesson_num']-1 : null;
        $questionsArray = [];
        $ddArray = [];
        foreach ($productGroups as $unitKey => $productGroup){
            $includedUnit = false;
            // check if unit is included in filter
            if (!is_null($selectedUnitKey)){
                if ($selectedUnitKey == $unitKey){
                    $includedUnit = true;
                }
            }else{
                if ($currentUnitKey >= $unitKey){
                    $includedUnit = true;
                }
            }

            if ($includedUnit === true){
                    foreach ($productGroup->getLessons as $lessonKey => $groupLesson){
                        $includedLesson = false;
                        // check if lesson is included in filter
                        if (!is_null($selectedLessonKey)){
                            if ($selectedLessonKey == $lessonKey){
                                $includedLesson = true;
                            }
                        }else{
                            if ($currentLessonKey >= $lessonKey){
                                $includedLesson = true;
                            }
                        }

                        if ($includedLesson){
//                            $ddArray[] = [
//                                'id' => $groupLesson->id,
//                            ];
                            $lessonForms = $groupLesson->getAvailableForms();
                            foreach ($lessonForms as $lessonForm){
                                if ($lessonForm){
                                    foreach ($lessonForm->items as $formItem){
                                        if ($formItem->type != FormItem::TYPE_SECTION){
                                            $sourceFilterStatus = false;
                                            $taxAFilterStatus =  false;
                                            $uniformFilterStatus =  false;


                                            if (!is_null($input['source'])){
                                                // Source filter
                                                if ($input['source'] == 'all'){
                                                    $sourceFilterStatus = true;
                                                } elseif (
                                                    !empty($formItem['properties']) &&
                                                    !is_null($formItem['properties']['source']) &&
                                                    $formItem['properties']['source'] == $input['source']
                                                ){
                                                    $sourceFilterStatus = true;
                                                }
                                            }
                                            // Taxonomies_a filter end
                                            if (!is_null($input['taxonomies_a'])){
                                                // Source filter
                                                if ($input['taxonomies_a'] == 'all'){
                                                    $taxAFilterStatus = true;
                                                } elseif (
                                                    !empty($formItem['properties']) &&
                                                    !is_null($formItem['properties']['taxonomies_a']) &&
                                                    in_array($input['taxonomies_a'], $formItem['properties']['taxonomies_a'])
                                                ){
                                                    $taxAFilterStatus = true;
                                                }
                                            }
                                            // Taxonomies_a filter end

                                            // Uniform filter
                                            if (!is_null($input['uniform'])){
                                                if ($input['uniform'] == false){
                                                    $uniformFilterStatus = true;
                                                } elseif (
                                                    !empty($formItem['properties']) &&
                                                    !is_null($formItem['properties']['uniform']) &&
                                                    $formItem['properties']['uniform'] == 1
                                                ){
                                                    $uniformFilterStatus = true;
                                                }
                                            }
                                            // Uniform filter end





                                            if ($sourceFilterStatus && $taxAFilterStatus && $uniformFilterStatus){

                                                $title = $formItem->title;
                                                if ($formItem->type == FormItem::TYPE_FILL_THE_BLANK || $formItem->type == FormItem::TYPE_FILL_THE_BLANK_DRAG_AND_DROP){
                                                    $title = subContent($formItem->getFillableBlank($formItem->id, false), 75);
                                                }


                                                $questionsArray[] = [
                                                    'id' => $formItem->id,
                                                    'title' => $title,
                                                    'type' => $formItem->type,
                                                ] ;
                                            }

                                        }
                                    }
                                }
                            }

                        }


                    }
            }

        }

//        array:8 [
//            "id" => 1
//  "unit_num" => "1"
//  "unit_status" => true
//  "lesson_num" => "2"
//  "lesson_status" => true
//  "source" => "0"
//  "taxonomies_a" => null
//  "uniform" => false
//]
        return response($questionsArray, 200);
//        return response($ddArray, 200);
    }

    /**
     * @param Request $request
     * @param Lesson $lesson
     * @return Application|ResponseFactory|Response
     */
    function smartStore(Request $request, Lesson $lesson){
        $requestInput = $request->only(['settings', 'groups']);
        $settings = $requestInput['settings'];
        $groups = $requestInput['groups'];
        $owner = $lesson;
        $user = getAuthUser();
        // create new form
        $input['title'] = $settings['title'];
        $input['description'] = $settings['description'];
        $input['position'] = $settings['position'];
        $input['version'] = 0;
        $input['master_id'] = null;
        $input['status'] = 1;
        $input['creator_id'] = $user->id;
        $input['editor_id'] = $user->id;
        $ownerId = !empty($owner) ? $owner->id : 0;
        $section = 0;
        $position = 0;

        // form properties
        $properties = [
            'score_type' => isset($settings['score_type']) ?  $settings['score_type'] : null,
            'passing_score' => isset($settings['passing_score']) ?  $settings['passing_score'] : null,
            'has_time_limit' => isset($settings['has_time_limit']) ?  1 : 0,
            'time_limit' => isset($settings['time_limit']) ?  $settings['time_limit'] : '',
            'attempts_number' => isset($settings['attempts_number']) ?  $settings['attempts_number'] : null,
            'shuffle_questions' => isset($settings['shuffle_questions']) ?  1 : 0,
            'shuffle_groups' => isset($settings['shuffle_groups']) ?  1 : 0,
            'display_type' => isset($settings['display_type']) ?  $settings['display_type'] : null,
            'direction' => isset($settings['direction']) ?  $settings['direction'] : null,
            'feedback_correct' => isset($settings['feedback_correct']) ?  $settings['feedback_correct'] : null,
            'feedback_incorrect' => isset($settings['feedback_incorrect']) ?  $settings['feedback_incorrect'] : null,
            'feedback_retry' => isset($settings['feedback_retry']) ?  $settings['feedback_retry'] : null,
            'submission_title' => isset($settings['submission_title']) ?  $settings['submission_title'] : null,
        ];
        $input['properties'] = $properties;
        // create new form
        $form =  Form::create($input);
        $form->slug = Hashids::encode($user->getTenancyId(),$ownerId,$form->id); // change this
        $form->hash_id = Hashids::encode($user->getTenancyId(),$ownerId,$form->id);
        $form->save();
        // attach created form to the owner (Lesson)
        if(!empty($owner)){
            $owner->forms()->attach($form->id);
        }

        // create form items
        foreach ($groups as $groupKey => $group){
            // create group container (Section)
            $section++;
            $position++;
            $sectionItemCount = 0;
            $sectionAllowedQuestionsToAnswer = $group['allowedNumber'];
            $itemType = FormItem::TYPE_SECTION;
            $newSection['title'] = $group['title'];
            $newSection['description'] = $group['description'];
            $newSection['position'] = $position;
            $newSection['section'] = $section;
            $newSection['type'] = $itemType;
            $newSection['form_id'] = $form->id;
            $newSection['status'] = 1; // default
            $newSection['creator_id'] = $user->id;
            $newSection['editor_id'] = $user->id;
            $properties = [
                'width' =>  null,
                'score' => 0,
                'source' => null,
                'placeholder' =>  null,
                'difficulty' =>  null,
                'display' => null,
                'answer_time' => 0,
                'answer_time_within' => null,
                'shuffle_options' => $group['shuffleQuestions'] ? 1 : 0,
                'shuffle_questions' =>  $group['shuffleQuestions'] ? 1 : 0,
                'uniform' => 0,
                'tags' => null,
                'allowed_number' => $sectionAllowedQuestionsToAnswer,
                'evaluation' => 1,
                'taxonomies_a' => array(),
            ];
            $newSection['properties'] = $properties;
            $newFormSection =  FormItem::create($newSection);
            $newFormSection->hash_id = Hashids::encode($user->getTenancyId(),$form->id,$newFormSection->id);
            $newFormSection->save();

            // create section's formItems
            if (!empty($group['items'])){
                // foreach group item
                foreach ($group['items'] as $groupItemKey => $groupItem){
                $sectionItemCount++;
                $position++;
                $selectedQuestionItemId = $groupItem['selectedQuestionItemId'];
                    if (!is_null($selectedQuestionItemId)){
                    $formItem = FormItem::find($selectedQuestionItemId); // get form item to duplicate
                        if (!empty($formItem)){
                        $newFormItem = $formItem->replicate();
                        $newFormItem->push();
                        // update duplicated formItem
                        $newFormItem->form_id = $form->id;
                            if ($newFormItem->type == FormItem::TYPE_FILL_THE_BLANK || $newFormItem->type == FormItem::TYPE_FILL_THE_BLANK_DRAG_AND_DROP){
                                $blank = $newFormItem->options['paragraph'];
                                $newBlank = str_replace("item_blank_option[".$formItem->id."]", "item_blank_option[".$newFormItem->id."]", $blank);
                                $newBlank2 = str_replace("item_blank_option_mark[".$formItem->id."]", "item_blank_option_mark[".$newFormItem->id."]", $newBlank);
                                $newItemBlanks = [
                                    'id' => $newFormItem->id,
                                    'paragraph' => $newBlank2,
                                    'paragraph_blanks' => $newFormItem->options['paragraph_blanks'],
                                    'alignment' => $newFormItem->options['alignment']
                                ];
                                $newFormItem->options = $newItemBlanks;
                            }
                            $newFormItem->section = $section;
                            $newFormItem->position = $position;
                            $newFormItem->save();

                            // update section score
                            if (empty($sectionAllowedQuestionsToAnswer) || $sectionAllowedQuestionsToAnswer >= $sectionItemCount){
                                $newFormSection->score = $newFormSection->score + $newFormItem->score;
                                $newFormSection->save();
                            }
                        }
                    }
                }
                // End of foreach group item
            }
            // End of create section's formItems

        }
        // End of create form items

        $formArray = [
            'title' => $form->title,
            'count' => $form->items->where('type', '!=', FormItem::TYPE_SECTION)->count(),
            'edit_url' => route('store.form.edit', [$lesson->slug, $form->hash_id]),
        ];


        return response($formArray, 200);
    }
}
