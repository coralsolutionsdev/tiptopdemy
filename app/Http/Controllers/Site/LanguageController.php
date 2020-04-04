<?php

namespace App\Http\Controllers\Site;

use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class LanguageController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Languages';
        $this->breadcrumb = [
            'Languages' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $languages = Language::latest()->get();
        $LanguageKys = array();
        foreach ($languages as $language){
            $keys =  array();
            $jsonString = file_get_contents(base_path('resources/lang/'.$language->code.'.json'));
            $data = json_decode($jsonString, true);
            if (!empty($data)){
                foreach ($data as $key => $trans){
                    $keys[$language->code] = $trans;
                    $LanguageKys[$key] = $keys;
                }
            }
        }
        return view('site.languages.index', compact('page_title','breadcrumb','languages', 'LanguageKys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $page_title =  $this->page_title . ' - ' .__('Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Create' => ''
            ];
        $languages = Language::all();
        return view('site.languages.create', compact('page_title','breadcrumb', 'languages'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $input =  $request->only(['name', 'position', 'status']);
        $input['code'] = strtolower(substr($input['name'] ,0,2));
        Language::create($input);
        fopen(base_path('resources/lang/') .$input['code'].'.json','w');
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('languages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Language $language
     * @return void
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Language $language
     * @return void
     */
    public function edit(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Language $language
     * @return void
     */
    public function update(Request $request, Language $language)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Language $language
     * @return void
     */
    public function destroy(Language $language)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateKeys(Request $request){
        $input = $request->only(['key', 'trans']);
        $keys = $input['key'];
        $trans = $input['trans'];
        $languages = Language::all();
        foreach ($languages as $language){
        $lang = $language->code;
        $jsonString = file_get_contents(base_path('resources/lang/'.$lang.'.json'));
        $data = json_decode($jsonString, true);
        // Update Key
            foreach ($keys as $id => $key){
                $data[$key] = $trans[$id][$lang];
            }
        // Write File JSON_UNESCAPED_UNICODE JSON_PRETTY_PRINT
        $newJsonString = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents(base_path('resources/lang/'.$lang.'.json'), stripslashes($newJsonString));
        }
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('languages.index');
    }
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
