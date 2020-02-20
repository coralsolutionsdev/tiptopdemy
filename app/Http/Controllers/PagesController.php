<?php

namespace App\Http\Controllers;

use App\Layout;
use Illuminate\Http\Request;
use DB;
use App\BlogPost;
use App\Banner;
use App\site;
use App\Contact;

class PagesController extends Controller
{
    //
    public function __construct()
    {
       // $this->middleware('');
    }

    public function GetIndex(){

        $layout = Layout::find(getSite()->layout_id);
        return view('welcome', compact('layout'));
        
    }
    public function Offline(){
        $contacts = Contact::latest()->paginate(5);

        $site = Site::all()->last();
        if($site->active == 0)
        {
            //return redirect()->route('offline');
            return view('offline',compact('contacts'));
            
        }   
        return redirect()->route('main');
        
    }
   
    public function GetAbout(){
        return view('about');
        
    }
   
}
