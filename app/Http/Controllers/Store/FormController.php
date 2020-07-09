<?php

namespace App\Http\Controllers\Store;

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
        $page_title = '';
        return view('store.forms.create', compact('page_title', 'lesson'));
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
        return view('store.forms.frontend.show', compact('product','page_title','breadcrumb', 'lesson', 'prevLesson', 'nextLesson', 'form'));

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
        return view('store.forms.create', compact('page_title', 'lesson', 'form'));
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
//        dd($items);
        return response($items, 200);
    }
}
