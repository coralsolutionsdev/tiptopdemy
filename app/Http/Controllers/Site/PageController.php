<?php

namespace App\Http\Controllers\Site;

use App\Services\FileAssetManagerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use App\Banner;
use DB;
use auth;
use Image;
use Storage;

class PageController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'getPage']]);
        $this->page_title = 'Pages';
        $this->breadcrumb = [
            'Pages' => '',
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
        $pages = Page::latest()->paginate(5);
        return view('pages.index', compact('page_title','breadcrumb','pages','page_title'));
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
        $banners = Banner::where('group',Banner::GROUP_BASIC_BANNER)->get();
        $banners = $banners->pluck('title','id')->toArray();
        return view('pages.create', compact('page_title','breadcrumb','banners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')){
            
                $this->validate($request, [
                    'title'        => 'required',
                    'slug'          => 'required|alpha_dash|min:0|max:255|unique:pages,slug',
                        'image'        => 'sometimes|image',
                ]);
                $input = $request->only(
                    'title',
                    'body',
                    'image',
                    'banner_id',
                    'slug',
                    'status'
                );
                $input['user_id'] = Auth::user()->id;
                if(!empty($request->input('status'))){
                    $status =1;
                }else{
                    $status =0;
                }
                $input['status'] = $status;
                // upload save image
                if ($request->hasFile('image')) {
                    // upload and save image
                    $image = $request->file('image');
                    $location =  config('baseapp.page_image_storage_path');
                    $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                    $input['image'] = $uploaded_image;
                }

                Page::create($input);
                session()->flash('success', trans('main._success_msg'));
                return redirect()->route('pages.index');
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
        $page = Page::find($id);
        return view('blog.show', compact('post'));
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
        $page = Page::find($id);
        $banners = Banner::where('group',Banner::GROUP_BANNER_PAGE)->get();
        $banners = $banners->pluck('title','id')->toArray();
        return view('pages.create', compact('page_title','breadcrumb','page', 'banners'));
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
        if ($request->isMethod('PUT')){

            $page = Page::find($id);
            if ($request->input('slug') != $page->slug){
                $this->validate($request, [
                    'slug'         => 'alpha_dash|min:0|max:255|unique:blog_posts,slug',
                ]);

            }
            $this->validate($request, [
                'title'        => 'required',
                'image'        => 'sometimes|image',
            ]);
            $input = $request->only(
                'title',
                'body',
                'image',
                'banner_id',
                'slug',
                'status'
            );
//            $input['user_id'] = Auth::user()->id;
            if(!empty($request->input('status'))){
                $status =1;
            }else{
                $status =0;
            }
            $input['status'] = $status;
            // upload save image
            if ($request->hasFile('image')) {
                // upload and save image
                $image = $request->file('image');
                $location =  config('baseapp.page_image_storage_path');
                $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                $input['image'] = $uploaded_image;
                // Delete old image
                FileAssetManagerService::ImageDestroy($page->image);
            }

            $page->update($input);
            session()->flash('success', __('updated successfully'));
            return redirect()->route('pages.index');
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
        $page = Page::find($id);
        FileAssetManagerService::ImageDestroy($page->image);
        $page->delete();

        session()->flash('success',trans('main._delete_msg'));
                return redirect()->route('pages.index');
    }

     public function getPage($url){

        $page = Page::where('slug',$url)->first();
        if (empty($page)){
            abort('404');
        }
        return view('pages.show', compact('page'));

    }
}
