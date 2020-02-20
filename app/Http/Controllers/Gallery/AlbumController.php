<?php

namespace App\Http\Controllers\Gallery;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use DB;
use App\GalleryAlbum;
use App\GalleryImage;
use Auth;

class AlbumController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['GetIndex','show']]);
        $this->page_title = 'Gallery Albums';
        $this->breadcrumb = [
            'Gallery' => '',
            'Albums' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetIndex()
    {
        //
        $albums = GalleryAlbum::latest()->where('status', 1)->paginate(12);
        $page_title =  'Gallery';
        $breadcrumb =  $this->breadcrumb;
        foreach ($albums as $album) {
            # code...
            $images = $album->images;
            if (!empty($images)){
                $album->cover = !empty($images->last()) ? $images->last()->image : '';
                $album->images_count = $images->count();
            }
        }
        return view('gallery.index', compact('page_title', 'breadcrumb', 'albums','images'));
       // return dd($albums);
    }

    public function index()
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $albums = GalleryAlbum::latest()->paginate(5);
        return view('gallery.albums.index', compact('page_title','breadcrumb','albums'));
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
        if ($request->isMethod('POST')){
        $this->validate($request, [
                 'title'         => 'required',
                 'status'        => 'bool',
             ]);
                $album = new GalleryAlbum();
                if(!empty($request->input('status'))){
                    $status =1;
                }else{
                    $status =0;
                } 
                $album->title = $request->input('title');
                $album->description = $request->input('description');
                $album->status = $status;
                $album->user_id = auth::user()->id;
                $album->save();
                session()->flash('success',trans('main._success_msg'));
                return redirect()->route('albums.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        $album = GalleryAlbum::where('slug',$slug)->first();
        if (empty($album)){
            abort('404');
        }
        $images = GalleryImage::latest()->where('album_id', $album->id)->where('status','1')->paginate(9);
        $page_title =  $album->title;
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $album->title => ''
            ];
        return view('gallery.albums.show',compact('page_title', 'breadcrumb', 'images', 'album'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $album = GalleryAlbum::find($id);
        return view('gallery.albums.edit', compact('page_title','breadcrumb','album'));
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
                'title'         => 'required',
                'status'        => 'bool',
            ]);
            if(!empty($request->input('status'))){
                    $status =1;
                }else{
                    $status =0;
                }
            $album = GalleryAlbum::find($id);
            if ($album->title != $request->input('title')){
                $slug = SlugService::createSlug(GalleryAlbum::class, 'slug', $request->input('title'), ['unique' => true]);
                $album->slug = $slug;
            }
            $album->title = $request->input('title');
            $album->description = $request->input('description');
            $album->status = $status;
            $album->save();
            session()->flash('success',trans('main._update_msg'));
            return redirect()->route('albums.index');
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
        $album = GalleryAlbum::find($id);
        $images = GalleryImage::all()->where('album_id', '=', $id);
        foreach ($images as $image) {
            # code...
            if (!empty ( $image->image )) {
                $oldImage = $image->image;
                Storage::delete('gallery/images/'. $image->user_id .'/'. $oldImage);
                }
            $image->delete();
        }
        $album->delete();
        session()->flash('success', trans('main._delete_msg'));
        return redirect()->route('albums.index');
    }
}
