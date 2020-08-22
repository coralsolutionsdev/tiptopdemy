<?php

namespace App\Http\Controllers\Store;

use App\Category;
use App\Http\Controllers\Controller;
use App\Modules\Course\Lesson;
use App\Modules\Form\Form;
use App\Modules\Form\FormItem;
use App\Modules\Group\Group;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Vinkla\Hashids\Facades\Hashids;

class FormController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['show']]);
        $this->page_title = 'Lesson quiz';
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
        $ownerId = $lesson->id;
        $ownerType = Form::OWNER_TYPE_LESSON;
        return view('store.forms.create', compact('page_title', 'breadcrumb', 'lesson', 'ownerId', 'ownerId', 'ownerType'));
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
        $breadcrumb =  [
            __('main.Store') => '',
            __('main.Products') => '',
            $product->name => '',
            __('main.Lessons') => '',
            $lesson->title => '',
        ];
        $prevLesson = null;
        $nextLesson = null;
        $productLessons =  $product->lessons->sortBy('position');
        foreach ($productLessons as $key => $item) {
            if ($item->id == $lesson->id) {
                $prevLesson = $productLessons->get($key - 1);
                $nextLesson = $productLessons->get($key + 1);
                break;
            }
        }
        $displayType = !is_null($form['properties']['display_type']) ? $form['properties']['display_type'] : 1;
        return view('store.forms.frontend.show', compact('product','page_title','breadcrumb', 'lesson', 'prevLesson', 'nextLesson', 'form', 'displayType'));

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
        $categories = Category::where('type', Category::TYPE_FORM_TEMPLATE)->where('parent_id', 0)->get();
        return view('store.forms.create', compact('page_title', 'lesson', 'form', 'categories'));
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
        $input['type'] = Form::TYPE_FORM;
        $form = Form::createOrUpdate($input,$lesson, $form);
        session()->flash('success', trans('main._update_msg'));
        return redirect()->route('store.form.edit', [$lesson->slug, $form->slug]);

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
}
