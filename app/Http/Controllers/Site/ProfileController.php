<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\BlogPost;
use App\GalleryImage;

class ProfileController extends Controller
{
     public function __construct()
    {
    $this->middleware('authadmin', ['only' => ['edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('profile.index');
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
        $posts_count = BlogPost::all()->where('user_id', '=', $id)->count();
        $pictures_count = GalleryImage::all()->where('user_id', '=', $id)->count();

        //blog
        

        $user = User::find($id);
        return view('profile.show', compact('user', 'posts_count', 'pictures_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $posts_count = BlogPost::all()->where('user_id', '=', $id)->count();
        $pictures_count = GalleryImage::all()->where('user_id', '=', $id)->count();
        $user = User::find($id);
        return view('profile.edit', compact('user', 'posts_count', 'pictures_count'));
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
}
