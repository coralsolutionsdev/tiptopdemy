<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Site;

class SiteController extends Controller
{

    public function __construct()
    {
    $this->middleware('auth', ['except' => ['create','store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $count = Site::all()->count();
        if($count ==0){

            return view('installation.install');
        }else{
            session()->flash('danger', 'Site already installed !!');
            return redirect()->route('main');
        }
        
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       // if($request->isMethod('POST')){
         if ($request->isMethod('post')){

            $this->validate($request, [
                'site_name'     => 'required|string|max:255',
                'desicription'  => 'required|string',
                'lang'          => 'required|string',
                'theme'         => 'required|string',
                'active'        => 'bool',
                'registration'  => 'bool',
                'email'         => 'required|string|email|max:255|unique:users',
                'password'      => 'required|string|confirmed',
                ]);
            
            $site = new Site();
            $site->name = $request->input('site_name');
            $site->desicription = $request->input('desicription');
            $site->lang = $request->input('lang');
            $site->theme = $request->input('theme');
            if(!empty($request->input('active'))){
                            $site->active =1;
                        }else{
                            $site->active =0;
                        }
            if(!empty($request->input('registration'))){
                            $site->registration =1;
                        }else{
                            $site->registration =0;
                        }

            $site->installed = 1;
            $site->simple_data = 0;
            $site->version = 1.0;
            $site->save();

            session()->flash('success', 'Site installed successfully');

            User::create([
            'name' => $request['admin_name'],
            'email' => $request['email'],
            'gender' => 1,
            'role' => 'admin',
            'lang' => $request['lang'],
            'avatar' => 'male.png',
            'status' => 1,
            'password' => bcrypt($request['password']),
            ]);

            
            return redirect()->route('main');
            //return redirect()->route('site.show',$site->id);
            
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
        $site = Site::find($id);
        $admin = User::all()->last();
        return view('installation.siteinfo', compact('site','admin'));
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
