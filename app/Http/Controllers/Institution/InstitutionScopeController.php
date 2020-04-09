<?php

namespace App\Http\Controllers\Institution;

use App\Institution\InstitutionScope;
use App\Page;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class InstitutionScopeController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Institutions Scopes';
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
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $institutions = InstitutionScope::latest()->paginate(15);
        return view('institutions.scopes.index', compact('page_title','breadcrumb','institutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title =  $this->page_title . ' - ' .__('create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Create' => ''
            ];
        return view('institutions.scopes.create', compact('page_title','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param InstitutionScope $scope
     * @return Response
     */
    public function store(Request $request, InstitutionScope $scope)
    {
        $input = $request->only($scope->getFillable());
        //Default values
        if (empty($input['position'])) {
            $input['position'] = 1;
        }
        if (empty($input['status'])) {
            $input['status'] = 1;
        }
        $input['user_id'] = Auth::user()->id;
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        if(!empty($input['default'])){
            $default = 1;
            $scopes = InstitutionScope::all();
            if (!empty($scopes)){
                foreach ($scopes as $scopeItem){
                    $scopeItem->default =  0;
                    $scopeItem->save();
                }
            }
        }else{
            $default = 0;
        }
        $input['default'] = $default;
        InstitutionScope::create($input);
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('institution.scopes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param InstitutionScope $institutionScope
     * @return Response
     */
    public function show(InstitutionScope $institutionScope)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param InstitutionScope $scope
     * @return Response
     */
    public function edit(InstitutionScope $scope)
    {
        $page_title =  $this->page_title . ' - ' .__('scope edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $scope->title => '',
                'Edit' => ''
            ];
        return view('institutions.scopes.create', compact('page_title','breadcrumb', 'scope'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param InstitutionScope $scope
     * @return Response
     */
    public function update(Request $request, InstitutionScope $scope)
    {
        $input = $request->only($scope->getFillable());
        //Default values
        if (empty($input['position'])) {
            $input['position'] = 1;
        }
        if (empty($input['status'])) {
            $input['status'] = 1;
        }
        $input['user_id'] = Auth::user()->id;
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        if(isset($input['default'])){
            $scopes = InstitutionScope::all();
            if (!empty($scopes)){
                foreach ($scopes as $scopeItem){
                    if ($scopeItem->id != $scope->id){
                        $scopeItem->default =  0;
                        $scopeItem->save();
                    }
                }
            }
            $default = 1;
        }else{
            $default = 0;
        }
        $input['default'] = $default;
        // update slug
        if ($scope->title != $request->input('title')){
            $slug = SlugService::createSlug(InstitutionScope::class, 'slug', $request->input('title'), ['unique' => true]);
            $scope->slug = $slug;
        }
        $scope->update($input);
        session()->flash('success', trans('Updated successfully'));
        return redirect()->route('institution.scopes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param InstitutionScope $scope
     * @return Response
     */
    public function destroy(InstitutionScope $scope)
    {
        $fields =  $scope->fields;
        $totalOptionsCount = 0;
        $fieldsCount = $fields->count();
        if ($fieldsCount > 0){
            foreach ($fields as $field){
                $options =  $field->options;
                $optionsCount = $options->count();
                if ($optionsCount > 0 ){
                    $totalOptionsCount = $totalOptionsCount + $optionsCount;
                    foreach($options as $option){
                        $option->delete();
                    }
                }
                $field->delete();
            }
        }
        $scope->delete();
        session()->flash('success', 'Scope has been deleted successfully, with the dependencies: '.$fieldsCount .' fields and '.$totalOptionsCount. ' options');
        return redirect()->route('institution.scopes.index');

    }
}
