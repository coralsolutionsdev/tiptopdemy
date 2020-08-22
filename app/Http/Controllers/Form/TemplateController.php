<?php

namespace App\Http\Controllers\Form;

use App\Category;
use App\Http\Controllers\Controller;
use App\Modules\Form\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
        $this->page_title = 'Forms Templates';
        $this->breadcrumb = [
            'Forms' => '',
            'Templates' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title =  'Forms Templates';
        $breadcrumb =  $this->breadcrumb;
        $templates = Form::latest()->where('type', Form::TYPE_FORM_TEMPLATE)->paginate(15);
        return view('forms.templates.index', compact('page_title', 'breadcrumb','templates'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title =  'Forms Templates';
        $breadcrumb =  $this->breadcrumb;
        $categories = Category::where('type', Category::TYPE_FORM_TEMPLATE)->where('parent_id', 0)->get();
        return view('forms.templates.create', compact('page_title', 'breadcrumb', 'categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['type'] = Form::TYPE_FORM_TEMPLATE;
        $form = Form::createOrUpdate($input,null);
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('form.templates.index');
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
     * @param Form $template
     * @return void
     */
    public function edit(Form $template)
    {
        $form = $template;
        $page_title =  'Forms Templates';
        $breadcrumb =  $this->breadcrumb;
        $categories = Category::where('type', Category::TYPE_FORM_TEMPLATE)->where('parent_id', 0)->get();
        $selectedCategories = $form->categories()->pluck('id')->toArray();
        $formProperties = $form->properties;
        return view('forms.templates.create', compact('page_title', 'breadcrumb', 'categories', 'selectedCategories', 'form', 'formProperties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Form $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $template)
    {
        $form = $template;
        $input = $request->all();
        $input['type'] = Form::TYPE_FORM_TEMPLATE;
        $input['update_type'] = Form::UPDATE_EXISTING_VERSION;
        $form = Form::createOrUpdate($input,null, $form);
        session()->flash('success',__('main._update_msg'));
        return redirect()->route('form.templates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Form $template
     * @return void
     */
    public function destroy(Form $template)
    {
        foreach ($template->items as $item){
            $item->delete();
        }
        $template->delete();
        session()->flash('success',__('main._delete_msg'));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clone(Request $request){

        $input = $request->all();
        $input['type'] = isset($input['type']) ? $input['type'] : Form::TYPE_FORM;
        $owner =  null;
        if (isset($input['owner_id']) && isset($input['owner_type'])){
            $owner = Form::getOwner($input['owner_id'], $input['owner_type']);
        }
        $form = Form::find($input['form_template_id']);
        if(empty($form)){
            abort(404);
        }
        $newForm = $form->clone($input);
        session()->flash('success', trans('main._save_msg'));
        if (isset($input['owner_type']) && $input['owner_type'] == Form::OWNER_TYPE_LESSON){
            return redirect()->route('store.form.edit', [$owner->slug, $newForm->hash_id]);
        }elseif($input['type'] == Form::TYPE_FORM_TEMPLATE){
            return redirect()->back();
        }

    }
}
