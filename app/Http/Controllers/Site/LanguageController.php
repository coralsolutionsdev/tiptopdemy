<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    //
    public function GetLang($lang){
    	
        
		if(in_array($lang, ['ar','en']))
		{
			if(auth()->user())
			{
				$user = auth()->user();
				$user->lang = $lang;
				$user->save();
			}else{

				if(session()->has('lang'))
				{
					session()->forget('lang');
				}

				session()->put('lang',$lang);
			}

		}
		else{
			if(auth()->user()){
				$user = auth()->user();
				$user->lang = auth()->user()->lang;
				$user->save();
			}else{
				
				if(session()->has('lang')){
					session()->forget('lang');
				}
				session()->put('lang',auth()->user()->lang);
			}
			
		}
		return back();
        
    }
}
