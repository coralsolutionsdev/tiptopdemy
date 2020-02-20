<?php

namespace App\Http\Controllers\Model;

use App\Services\FileAssetManagerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Banner;
use Storage;
use auth;
use Image;

class BannerController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['GetIndex','show']]);
        $this->page_title = 'Banners';
        $this->breadcrumb = [
            'banners' => '',
        ];
    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $selected_group = null;
        if (!empty($request->group_search)){
            $selected_group = $request->group_search;
            $banners = Banner::latest()->where('group', $selected_group)->paginate(5);
        }else{
            $banners = Banner::latest()->paginate(5);
        }
        $banner_group =  Banner::GROUP_ARRAY;
        return view('models.banner.index', compact('page_title','breadcrumb','banners','banner_group','selected_group'));
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
        $banner_type = 'banner';
        $banner_group =  Banner::GROUP_ARRAY;
        $grid_array = Banner::GRID_ARRAY;
        return view('models.banner.create', compact('page_title','breadcrumb','banner_type','banner_group','grid_array'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($request->isMethod('post')){
            $this->validate($request, [
                 'title'        => 'required',
                 'group'         => 'required',
                 'status'       => 'bool',
                 'image'        => 'sometimes'
                ]);

            $input =  $request->only(
                'title',
                'image',
                'image_size',
                'content_alignment',
                'content',
                'link',
                'font_color',
                'grid',
                'group',
                'status',
                'order_id',
                'icon'
                );

            if(empty($input['content_alignment'])){
                $input['content_alignment'] = 'center';
            }
            if(empty($input['font_color'])){
                $input['font_color'] = 'light';
            }
            $input['grid'] = '12';
            $input['user_id'] = Auth()->user()->id;

            if(!empty($input['status'])){
                $status = 1;
            }else{
                $status = 0;
            }
            $input['status'] = $status;
            if(empty($input['order_id'])){
                $input['order_id'] = 1;
            }
            if ($request->hasFile('image')) {
                // upload and save image
                $image = $request->file('image');
                $location =  config('baseapp.banner_image_storage_path');
                $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                $input['image'] = $uploaded_image;
            }

            Banner::create($input);
            session()->flash('success','The banner has been successfully added!');
            return redirect()->route('banners.index');

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
        $banner = Banner::find($id);
        $banner_type = $banner->group;
        $banner_group =  Banner::GROUP_ARRAY;
        $grid_array = Banner::GRID_ARRAY;
        return view('models.banner.create', compact('page_title','breadcrumb','banner', 'banner_type','banner_group','grid_array'));


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
        //
        if ($request->isMethod('PUT')){
            $this->validate($request, [
                'title'        => 'required',
                'group'         => 'required',
                'status'       => 'bool',
                'image'        => 'sometimes'
            ]);

            $input =  $request->only(
                'title',
                'image',
                'image_size',
                'content_alignment',
                'content',
                'link',
                'font_color',
                'grid',
                'group',
                'status',
                'user_id',
                'order_id',
                'icon'
            );
            $banner = Banner::find($id);

            if(empty($input['content_alignment'])){
                $input['content_alignment'] = 'center';
            }
            if(empty($input['font_color'])){
                $input['font_color'] = 'light';
            }
//            if(empty($input['gird'])){
//            }
            $input['grid'] = '12';
            $input['user_id'] = Auth()->user()->id;

            if(!empty($input['status'])){
                $status = 1;
            }else{
                $status = 0;
            }
            $input['status'] = $status;
            if(empty($input['order_id'])){
                $input['order_id'] = 1;
            }
            if ($request->hasFile('image')) {
                // upload and save image
                $image = $request->file('image');
                $location =  config('baseapp.banner_image_storage_path');
                $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                $input['image'] = $uploaded_image;
                // Delete old image
                FileAssetManagerService::ImageDestroy($banner->image);
            }
            $banner->update($input);
            session()->flash('success','The banner has been successfully updated!');
            return redirect()->route('banners.index');


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
        $banner = Banner::find($id);
        FileAssetManagerService::ImageDestroy($banner->image);
        $banner->delete();
        session()->flash('success','The banner has been succefully deleted!');
        return redirect()->route('banners.index');



    }
    public function GetCarousel(){
        $banners = Banner::latest()->where('group', '=', Banner::GROUP_SLIDE_SHOW)->paginate(5);
        return view('models.banner.carousel', compact('banners'));
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CreateCarousel()
    {
        //
        $banner_type = Banner::GROUP_SLIDE_SHOW;
        return view('models.banner.create', compact('banner_type'));
    }

}
