<?php

namespace App\Http\Controllers\Site;

use App\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;
use Auth;


class MenuController extends Controller
{

    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Menus';
        $this->breadcrumb = [
            'Menus' => '',
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
        $menus = Menu::latest()->paginate(5);
        return view('menu.index', compact('page_title','breadcrumb','menus'));
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
        $positions = Menu::POSITIONS_ARRAY;
        return view('menu.create', compact('page_title','breadcrumb','positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input =  $request->all();
        if ($request->isMethod('post')){

            $items =  array();
//            $input = $request->only('layout_title','layout_description','title','description','background','group','structure','container_type');
            foreach ($input['item-title'] as $key => $value){
                $items[$key]['title'] = $value;
            }
            foreach ($input['item-link'] as $key => $value){
                $items[$key]['link'] = $value;
            }

            $this->validate($request, [
                 'title'        => 'required',
                 'status'       => 'bool',
                ]);
            
            $input['user_id'] = auth::user()->id;
            if(!empty($request->input('status'))){
                $status =1;
            }else{
                $status =0;
            }
            $input['items'] = $items;
            $input['position'] = Menu::POSITION_TOP_NAV;
            $input['status'] = $status;

            Menu::create($input);
            session()->flash('success',trans('main._success_msg'));

            return redirect()->route('menus.index');
            
            }
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
        $positions = Menu::POSITIONS_ARRAY;
        $menu = Menu::find($id);
        return view('menu.create', compact('page_title','breadcrumb','menu','positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $input =  $request->all();
        if ($request->isMethod('PUT')){
            $menu = Menu::find($id);
            $items =  array();
//            $input = $request->only('layout_title','layout_description','title','description','background','group','structure','container_type');
            foreach ($input['item-title'] as $key => $value){
                $items[$key]['title'] = $value;
            }
            foreach ($input['item-link'] as $key => $value){
                $items[$key]['link'] = $value;
            }

            $this->validate($request, [
                'title'        => 'required',
                'status'       => 'bool',
            ]);
            $input['user_id'] = Auth::user()->id;
            if(!empty($request->input('status'))){
                $status =1;
            }else{
                $status =0;
            }
            $input['items'] = $items;
            $input['position'] = Menu::POSITION_TOP_NAV;
            $input['status'] = $status;

            $menu->update($input);
            session()->flash('success',__('Updated successfully'));

            return redirect()->route('menus.index');

        }
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
        $menu = Menu::find($id);
        $menu->delete();

        session()->flash('success',trans('main._delete_msg'));
        return redirect()->route('menus.index');
    }

    /**
     * @param $layout_id
     * @return array
     */
    public function getMenuItemsStructure($menu_id)
    {
        $menu = Menu::find($menu_id);
        return ['structure' => $menu->items];
    }
}
