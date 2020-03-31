<?php

namespace App\Http\Controllers;

use App\Jobs\SendValidationMail;
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

        // Read File
//        $file=fopen(base_path('resources/lang/') .'ar.json','w');

//        $jsonString = file_get_contents(base_path('resources/lang/ar.json'));
//        $data = json_decode($jsonString, true);
//
//
//        // Update Key
//        $data['login'] = "login";
//        $data['get started'] = "Register";
//        $data['register'] = "Register";
//        // Write File
//        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
//        file_put_contents(base_path('resources/lang/ar.json'), stripslashes($newJsonString));
//

//        dd('here',$data);
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
