<?php

namespace App\Http\Controllers\Form;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Form Categories';
        $this->breadcrumb = [
            'Form' => '',
            'Categories' => '',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $type
     * @return Response
     */
    public function index($type = null)
    {
        $page_title = "Form categories";
        $breadcrumb = $this->breadcrumb;
        $categoryType = !empty($type) ? $type : Category::TYPE_FORM;
        $categoriesCollection =  $tree_categories = Category::where('type', $categoryType)->where('parent_id',0)->get();
        return view('categories.index', compact('page_title','breadcrumb','categoriesCollection', 'categoryType'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
