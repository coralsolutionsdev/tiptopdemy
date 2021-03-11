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
        return view('forms.smart.create', compact('page_title', 'breadcrumb', 'lesson'));
    }
}
