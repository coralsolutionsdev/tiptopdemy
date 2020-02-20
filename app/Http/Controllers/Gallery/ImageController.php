<?php

namespace App\Http\Controllers\Gallery;

use App\Services\FileAssetManagerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\GalleryAlbum;
use App\GalleryImage;
use auth;
use Image;


class ImageController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Gallery images';
        $this->breadcrumb = [
            'Gallery' => '',
            'Images' => '',
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
        $albums = GalleryAlbum::all();
        if ($albums->count() < 1){
            session()->flash('warning', 'You haven\'t created any albums. Please create new one before proceed. ');
        }
        $images = GalleryImage::latest()->orderBy('id', 'desc')->paginate(5);
        return view('gallery.images.index', compact('page_title','breadcrumb','albums', 'images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

                // upoad save image
                $this->validate($request, [
                 'title'        => 'required',
                 'image'        => 'required',
                 'status'       => 'bool',
                 'album_id'     => 'required',
                ]);
                $input = $request->only(
                    'title',
                    'description',
                    'image',
                    'album_id',
                    'status'
                );
                if ($request->hasFile('image')) {
                    $images = $request->file('image');

                    foreach ($images as $image) {
                        # code...
//                        $image = $request->file('image');
                        $location = 'gallery/images';
                        $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                        $input['image'] = $uploaded_image;
                        $input['user_id'] = auth::user()->id;
                        if(!empty($request->input('status'))){
                            $status =1;
                        }else{
                            $status =0;
                        }
                        $input['status'] = $status;
                        GalleryImage::create($input);

                    }
                    session()->flash('success',trans('main._success_msg'));
                    return redirect()->route('images.index');
                }
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
        $image = GalleryImage::find($id);
        $albums = GalleryAlbum::all()->pluck('title','id')->toArray();
        return view('gallery.images.edit', compact('page_title','breadcrumb','albums','image'));
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

                // upoad save image
                $this->validate($request, [
                 'title'        => 'required',
                 'status'       => 'bool',
                 'album_id'     => 'required',
                ]);

                $input = $request->only(
                    'title',
                    'description',
                    'image',
                    'album_id',
                    'status'
                );
                $upload_image = GalleryImage::find($id);
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $location = 'gallery/images';
                    $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                    $input['image'] = $uploaded_image;

                    // Delete old image
                    if (!empty ( $uploaded_image->image )) {
                        $oldImage = $uploaded_image->image;
                        Storage::delete($oldImage);
                    }

                }
                if(!empty($request->input('status'))){
                    $status =1;
                }else{
                    $status =0;
                }
                $input['status'] = $status;
                $upload_image->update($input);
                session()->flash('success', trans('main._update_msg'));
                return redirect()->route('images.index');
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
        $image = GalleryImage::find($id);
           if (!empty ( $image->image )) {
                $oldImage = $image->image;
                Storage::delete('uploads/gallery/images/'. $oldImage);
           }
        $image->delete();

        session()->flash('success',trans('main._delete_msg'));
        return redirect()->route('images.index');
    }
}
