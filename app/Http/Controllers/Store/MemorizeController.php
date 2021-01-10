<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Modules\Course\Lesson;
use App\Modules\Form\Form;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Tags\Tag;
use Vinkla\Hashids\Facades\Hashids;

class MemorizeController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
        $this->page_title = 'Memorize';
        $this->breadcrumb = [
            'Memorize' => '',
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
        $page_title =  'Memorise - Create';
        $breadcrumb =  $this->breadcrumb;
        $tags = Tag::getWithType('memorize')->pluck('name', 'name');
        $selectedTags = array();
        $storeRoute = route('store.memorize.store', $lesson->slug);
        return view('forms.memorize.create', compact('page_title', 'breadcrumb', 'tags', 'selectedTags', 'lesson', 'storeRoute'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Lesson $lesson
     * @return Response
     */
    public function store(Request $request, Lesson $lesson)
    {
        $input = $request->only(['title', 'description', 'tags', 'time_to_answer', 'level', 'item_type', 'item_title', 'item_status', 'item_media_url', 'form_item_type_title']);
        $input['type'] = Form::TYPE_MEMORIZE;
        $form =  Form::createOrUpdateWithType($input,$lesson);
        $product = $lesson->product;
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('store.lessons.edit', [$product->slug, $lesson->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Lesson $lesson, $formHashId)
    {
        $form = Form::where('hash_id', $formHashId)->first();
        $page_title =  'Memorise - edit';
        $breadcrumb =  $this->breadcrumb;
        $tags = Tag::getWithType('memorize')->pluck('name', 'name');
        $selectedTags = $form->getTags();
        $storeRoute = route('store.memorize.update', [$lesson->slug, $form->hash_id]);
        return view('forms.memorize.create', compact('page_title', 'breadcrumb', 'tags', 'selectedTags', 'lesson', 'storeRoute', 'form'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Lesson $lesson, $formHashId)
    {
        $input = $request->only(['title', 'description', 'tags', 'time_to_answer', 'level', 'item_type', 'item_title', 'item_status', 'item_media_url', 'form_item_type_title']);
        $form = Form::where('hash_id', $formHashId)->first();
        if (empty($form)){
            abort(500);
        }
        $form = Form::createOrUpdateWithType($input,$lesson, $form);
        $product = $lesson->product;
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('store.lessons.edit', [$product->slug, $lesson->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    function getItems(Request $request){
        $input = $request->only('hash_id');
        if (!empty($input['hash_id'])){
            $form = Form::where('hash_id', $input['hash_id'])->first();
            if (!empty($form)){
                $items = $form->items;
                return response($items, 200);
            }
        }
        return response(array(), 500);
    }
}
