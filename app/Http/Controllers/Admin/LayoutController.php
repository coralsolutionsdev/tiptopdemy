<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Layout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LayoutController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['GetIndex','show']]);
        $this->page_title = 'Layouts';
        $this->breadcrumb = [
            'Layouts' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $layouts = Layout::latest()->paginate(5);

        return view('layouts.index',compact('page_title','breadcrumb','layouts','page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title =  $this->page_title . ' - ' .__('Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Create' => ''
            ];
        return view('layouts.create',compact('page_title','breadcrumb'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items =  array();
        $input = $request->only(['title', 'description', 'status', 'item_model',
            'item_code', 'item_name', 'item_description', 'item_grid',
            'item_parallel', 'item_alignment', 'item_background', 'item_banner_group',
            'item_banners', 'item_model_name', 'item_slider', 'item_slider_type',
            'item_container', 'item_grid_padding']);

        foreach ($input['item_model'] as $key => $value){
            $items[$key]['model'] = $value;
        }
        foreach ($input['item_model_name'] as $key => $value){
            $items[$key]['model_name'] = $value;
        }
        foreach ($input['item_code'] as $key => $value){
            $items[$key]['code'] = $value;
            if (!empty($input['item_banners']) && !empty($input['item_banners'][$value])){
                $items[$key]['item_banners'] = $input['item_banners'][$value];
            }
        }
        foreach ($input['item_name'] as $key => $value){
            $items[$key]['name'] = $value;
        }
        foreach ($input['item_description'] as $key => $value){
            $items[$key]['description'] = $value;
        }
        foreach ($input['item_grid'] as $key => $value){
            $items[$key]['grid'] = !is_null($value) ? $value : 1;
        }
        foreach ($input['item_grid_padding'] as $key => $value){
            $items[$key]['grid_padding'] = !is_null($value) ? $value : 1;
        }
        foreach ($input['item_parallel'] as $key => $value){
            $items[$key]['parallel'] = $value;
        }
        foreach ($input['item_alignment'] as $key => $value){
            $items[$key]['text_alignment'] = $value;
        }
        foreach ($input['item_banner_group'] as $key => $value){
            $items[$key]['banner_group'] = !is_null($value) ? $value : null;
        }
        foreach ($input['item_background'] as $key => $value){
            $items[$key]['background'] = !is_null($value) ? $value : 'light';
        }
        foreach ($input['item_slider'] as $key => $value){
            $items[$key]['slider'] = $value;
        }
        foreach ($input['item_slider_type'] as $key => $value){
            $items[$key]['slider_type'] = $value;
        }
        foreach ($input['item_container'] as $key => $value){
            $items[$key]['container'] = $value;
        }


        $input['structure'] = $items;
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        $input['theme'] = '';
        Layout::create($input);
        return redirect()->route('layouts.index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title =  $this->page_title . ' - ' .__('Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Edit' => ''
            ];
        $layout = Layout::find($id);
        return view('layouts.create',compact('page_title','breadcrumb','layout'));

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Layout $layout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Layout $layout)
    {
        $items =  array();
        $input = $request->only(['title', 'description', 'status', 'item_model',
            'item_code', 'item_name', 'item_description', 'item_grid',
            'item_parallel', 'item_alignment', 'item_background', 'item_banner_group',
            'item_banners', 'item_model_name', 'item_slider', 'item_slider_type',
            'item_container', 'item_grid_padding']);

        foreach ($input['item_model'] as $key => $value){
            $items[$key]['model'] = $value;
        }
        foreach ($input['item_model_name'] as $key => $value){
            $items[$key]['model_name'] = $value;
        }
        foreach ($input['item_code'] as $key => $value){
            $items[$key]['code'] = $value;
            if (!empty($input['item_banners']) && !empty($input['item_banners'][$value])){
                $items[$key]['item_banners'] = $input['item_banners'][$value];
            }
        }
        foreach ($input['item_name'] as $key => $value){
            $items[$key]['name'] = $value;
        }
        foreach ($input['item_description'] as $key => $value){
            $items[$key]['description'] = !empty($value) ? $value : '';
        }
        foreach ($input['item_grid'] as $key => $value){
            $items[$key]['grid'] = !is_null($value) ? $value : 1;
        }
        foreach ($input['item_grid_padding'] as $key => $value){
            $items[$key]['grid_padding'] = !is_null($value) ? $value : 1;
        }
        foreach ($input['item_parallel'] as $key => $value){
            $items[$key]['parallel'] = $value;
        }
        foreach ($input['item_alignment'] as $key => $value){
            $items[$key]['text_alignment'] = $value;
        }
        foreach ($input['item_banner_group'] as $key => $value){
            $items[$key]['banner_group'] = !is_null($value) ? $value : null;
        }
        foreach ($input['item_background'] as $key => $value){
            $items[$key]['background'] = !is_null($value) ? $value : 'light';
        }
        foreach ($input['item_slider'] as $key => $value){
            $items[$key]['slider'] = $value;
        }
        foreach ($input['item_slider_type'] as $key => $value){
            $items[$key]['slider_type'] = $value;
        }
        foreach ($input['item_container'] as $key => $value){
            $items[$key]['container'] = $value;
        }

        $input['structure'] = $items;
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        $input['theme'] = '';
        $layout->update($input);
        return redirect()->route('layouts.index');
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

    /**
     * @param $layout_id
     * @return array
     */
    public function getLayoutStructure($layout_id)
    {
        $layout = Layout::find($layout_id);
        return ['structure' => $layout->structure];
    }
    public function getGroupBanners($group)
    {
        $banners = Banner::where('group',$group)->where('status',1)->pluck('title','id')->toArray();
        return ['banners' => $banners];
    }
}

