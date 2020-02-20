<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\BlogPost;
use Auth;
use DB;

class AdminController extends Controller
{
    //
    public function GetDashboard(){
        
        $posts_count = DB::table('blog_posts')
                    ->count();
        $pages_count = DB::table('pages')
                    ->count();
        $users_count = DB::table('users')
                    ->count();
        $images_count = DB::table('gallery_images')
                    ->count();
        $posts = BlogPost::latest()->paginate(6);
        $users= User::latest()->paginate(4);



        return view('manage.dashboard', compact('posts_count','pages_count','users_count','images_count','posts','users'));
        
    }
}
