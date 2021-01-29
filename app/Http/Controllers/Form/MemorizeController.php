<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Http\Resources\Form\FormItem as FormItemResource;
use App\Modules\Form\FormItem;
use Illuminate\Http\Request;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_title =  'Memorises';
        $breadcrumb =  $this->breadcrumb;
        $memorizes = FormItem::where('type', FormItem::TYPE_MEMORIZE)->latest()->paginate(15);
        return view('forms.memorize.index', compact('page_title', 'breadcrumb', 'memorizes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title =  'Memorise - Create';
        $breadcrumb =  $this->breadcrumb;
        $tags = Tag::getWithType('memorize')->pluck('name', 'name');
        $selectedTags = array();
        return view('forms.memorize.create', compact('page_title', 'breadcrumb', 'tags', 'selectedTags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['title', 'description', 'tags', 'time_to_answer', 'level', 'item_id', 'item_description', 'item_default_title', 'item_lang', 'item_status', 'form_item_type_status']);
        FormItem::createOrUpdateMemorize($input);
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('form.memorize.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FormItem $memorize
     * @return \Illuminate\Http\Response
     */
    public function edit(FormItem $memorize)
    {
        $page_title =  'Memorise - Edit';
        $breadcrumb =  $this->breadcrumb;
        $tags = Tag::getWithType('memorize')->pluck('name', 'name');
        $selectedTags = $memorize->getTags();
        return view('forms.memorize.create', compact('page_title', 'breadcrumb', 'memorize','tags', 'selectedTags'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param FormItem $memorize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormItem $memorize)
    {
        $input = $request->only(['title', 'description', 'tags', 'time_to_answer', 'level', 'item_id', 'item_description', 'item_default_title', 'item_lang', 'item_status', 'form_item_type_status']);
        FormItem::createOrUpdateMemorize($input, $memorize);
        session()->flash('success', trans('main._update_msg'));
        return redirect()->route('form.memorize.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
