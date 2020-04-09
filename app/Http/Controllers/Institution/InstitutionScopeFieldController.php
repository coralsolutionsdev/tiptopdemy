<?php

namespace App\Http\Controllers\Institution;

use App\Institution\InstitutionScope;
use App\Institution\InstitutionScopeField;
use App\Institution\InstitutionScopeFieldOption;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;


class InstitutionScopeFieldController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Institutions Fields';
        $this->breadcrumb = [
            'Institutions' => '',
            'Scope' => '',
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
     * @param InstitutionScope $scope
     * @return Response
     */
    public function create(InstitutionScope $scope)
    {
        $page_title =  $this->page_title . ' - ' .__('Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $scope->title => '',
                'Field' => '',
                'Create' => ''
            ];
        $types = InstitutionScopeField::TYPE_ARRAY;
        $subTypes = InstitutionScopeFieldOption::TYPE_ARRAY;
        return view('institutions.fields.create', compact('page_title','breadcrumb', 'scope', 'types', 'subTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param InstitutionScope $scope
     * @param InstitutionScopeField $field
     * @return void
     */
    public function store(Request $request, InstitutionScope $scope)
    {
        $input = $request->only(['title', 'slug', 'description', 'default', 'type', 'level_id', 'level_title', 'level_status', 'level_default', 'scope_id', 'user_id', 'scope_slug', 'position', 'status','option_id', 'option_title', 'option_desc', 'option_type', 'option_position', 'removed_options']);
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        if(isset($input['default'])){
            $items = InstitutionScopeField::where('scope_id', $scope->id)->get();
            if (!empty($items)){
                foreach ($items as $item){
                    $item->default =  0;
                    $item->save();
                }
            }
            $default = 1;
        }else{
            $default = 0;
        }
        $input['default'] = $default;
        // update levels
        $levels =  $input['level_id'];
        $levelsArray =  array();
        foreach ($levels as $key => $id){
            $levelsArray[$id] = [
                'title' => isset($input['level_title'][$id]) ? $input['level_title'][$id] : 'level '.$id,
                'status' => isset($input['level_status'][$id]) ? 1 : 0,
                'default' => isset($input['level_default'][$id]) ? 1 : 0
            ];
        }
        $input['levels'] = $levelsArray;
        $field = InstitutionScopeField::create($input);
        $itemIds = isset($input['option_id']) ? $input['option_id'] :  array();
        foreach ($itemIds as $key => $id){
            $optionInput =  null;
            $optionInput['title'] = $input['option_title'][$key];
            $optionInput['description'] = $input['option_desc'][$key];
            $optionInput['field_id'] = $field->id;
            $optionInput['position'] = $input['option_position'][$key];
            $optionInput['status'] = 1;
            InstitutionScopeFieldOption::create($optionInput);
        }
        session()->flash('success', __('Added successfully'));
        return redirect()->route('institution.scopes.edit', $input['scope_slug']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InstitutionScopeField  $institutionScopeField
     * @return Response
     */
    public function show(InstitutionScopeField $institutionScopeField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param InstitutionScope $scope
     * @param InstitutionScopeField $field
     * @return Response
     */
    public function edit(InstitutionScope $scope, InstitutionScopeField $field)
    {
        $page_title =  $this->page_title . ' - ' .__('Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $scope->title => '',
                'Field' => '',
                $field->title => '',
                'Edit' => ''
            ];
        $types = InstitutionScopeField::TYPE_ARRAY;
        $subTypes = InstitutionScopeFieldOption::TYPE_ARRAY;
        return view('institutions.fields.create', compact('page_title','breadcrumb', 'scope', 'field', 'types', 'subTypes'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param InstitutionScope $scope
     * @param InstitutionScopeField $field
     * @return Response
     */
    public function update(Request $request, InstitutionScope $scope, InstitutionScopeField $field)
    {
        $input = $request->only(['title', 'slug', 'description', 'default','type', 'level_id', 'level_title', 'level_status', 'level_default', 'scope_id', 'user_id', 'scope_slug', 'position', 'status','option_id', 'option_title', 'option_desc', 'option_type', 'option_position', 'option_default', 'removed_options']);
        $itemIds = isset($input['option_id']) ? $input['option_id'] :  array();
        $removedOptions = isset($input['removed_options']) ? $input['removed_options'] :  array();
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        if(isset($input['default'])){
            $items = InstitutionScopeField::where('scope_id', $scope->id)->get();
            if (!empty($items)){
                foreach ($items as $item){
                    if ($item->id != $field->id){
                        $item->default =  0;
                        $item->save();
                    }
                }
            }
            $default = 1;
        }else{
            $default = 0;
        }
        $input['default'] = $default;

        // update slug
        if ($field->title != $request->input('title')){
            $slug = SlugService::createSlug(InstitutionScopeField::class, 'slug', $request->input('title'), ['unique' => true]);
            $field->slug = $slug;
        }
        // update levels
        $levels =  $input['level_id'];
        $levelsArray =  array();
        foreach ($levels as $key => $id){
            $levelsArray[$id] = [
                'title' => isset($input['level_title'][$id]) ? $input['level_title'][$id] : 'level '.$id,
                'status' => isset($input['level_status'][$id]) ? 1 : 0,
                'default' => isset($input['level_default'][$id]) ? 1 : 0
            ];
        }
        $input['levels'] = $levelsArray;

        $field->update($input);
        // update field options
        foreach ($itemIds as $key => $id){
            $optionInput =  null;
            $optionInput['title'] = $input['option_title'][$key];
            $optionInput['description'] = $input['option_desc'][$key];
            $optionInput['field_id'] = $field->id;
            $optionInput['position'] = $input['option_position'][$key];
            $optionInput['default'] = $input['option_default'][$key];
            $optionInput['status'] = 1;
            if (!empty($id)){
                // update
                $option = InstitutionScopeFieldOption::find($id);
                if (!empty($option)){
                    $option->update($optionInput);
                }
            }else{
                // new
                InstitutionScopeFieldOption::create($optionInput);
            }
        }
        // removed options
        foreach ($removedOptions as $optionId){
            $option = InstitutionScopeFieldOption::find($optionId);
            if (!empty($option)){
                $option->delete();
            }
        }
        session()->flash('success', __('updated successfully'));
        return redirect()->route('institution.scopes.edit', $scope->slug);
    }

    /**
     * Remove the specified resource from storage.
     * @param InstitutionScope $scope
     * @param InstitutionScopeField $field
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(InstitutionScope $scope, InstitutionScopeField $field)
    {
        $totalOptionsCount = 0;
            $options =  $field->options;
            $optionsCount = $options->count();
            if ($optionsCount > 0 ){
                $totalOptionsCount = $totalOptionsCount + $optionsCount;
                foreach($options as $option){
                    $option->delete();
                }
            }
            $field->delete();
        session()->flash('success', 'Field has been deleted successfully, with the dependencies: '.$totalOptionsCount. ' options');
        return redirect()->route('institution.scopes.edit', $scope->slug);
    }
}
