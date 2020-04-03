<?php

namespace App\Http\Controllers\Site;

use App\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;


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
     * @return Response
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
     * @return Response
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
     * @param Request $request
     * @return Response
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
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Menu $menu
     * @return Response
     */
    public function edit(Menu $menu)
    {
        $page_title =  $this->page_title . ' - ' .__('Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Edit' => ''
            ];
        $positions = Menu::POSITIONS_ARRAY;
        return view('menu.create', compact('page_title','breadcrumb','menu','positions'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Menu $menu
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, Menu $menu)
    {

        $input =  $request->all();
        if ($request->isMethod('PUT')){
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
     * @param Menu $menu
     * @return Response
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        session()->flash('success',trans('main._delete_msg'));
        return redirect()->route('menus.index');
    }

    /**
     * @param $menu_id
     * @return array
     */
    public function getMenuItemsStructure($menu_id)
    {
        $menu = Menu::find($menu_id);
        return ['structure' => $menu->items];
    }
}
