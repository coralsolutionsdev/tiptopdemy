<?php

namespace App\Http\Controllers\Admin;

use App\Layout;
use App\Module;
use App\Services\FileAssetManagerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Site;
use Storage;
use Auth;
use Image; 

class SettingController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Settings';
        $this->breadcrumb = [
            'Settings' => '',
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
        $layouts = Layout::where('status',1)->get()->pluck('title','id')->toArray();
        $languages = [
            'en' => 'EN (English)',
            'ar' => 'AR (العربية)',
        ];
        return view('site.index',compact('breadcrumb','layouts','page_title','languages'));
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
        if ($request->isMethod('PUT')){
            $this->validate($request, [
                'name'          => 'required|string|max:255',
                'lang'          => 'required|string',
                'theme'         => 'required|string',
                'logo_show'     => 'bool',
                'active'        => 'bool',
                'registration'  => 'bool',
                ]);

            $input = $request->only(
                [
                    'name',
                    'logo',
                    'logo_show',
                    'description',
                    'lang',
                    'theme',
                    'admin_theme',
                    'frontend_primary_color',
                    'admin_primary_color',
                    'layout_id',
                    'active',
                    'registration',
                    'version'
                ]
            );
            $site = Site::find($id);

            if(!empty($input['logo_show']))
            { $input['logo_show'] = 1;}
        else
            { $input['logo_show'] = 0; }

            if(!empty($input['active']))
            { $input['active'] = 1;}
        else
            { $input['active'] = 0; }

            if(!empty($input['registration']))
            { $input['registration'] = 1;}
        else
            { $input['registration'] = 0; }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $location = 'site/images';
                $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                $input['logo'] = $uploaded_image;
                // Delete old image
                if (!empty ( $site->logo )) {
                    $oldImage = $site->logo;
                    Storage::delete($oldImage);
                }
            }
            // theme settings
            $theme = [
                'theme_name' => $input['theme'],
                'primary_color' => $input['frontend_primary_color']
            ];
            $admin_theme = [
                'theme_name' => $input['admin_theme'],
                'primary_color' => $input['admin_primary_color']
            ];

            $input['theme'] = $theme;
            $input['admin_theme'] = $admin_theme;


            $site->update($input);
            session()->flash('success',trans('main._update_msg'));
            return redirect()->route('setting.index');
            
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
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getModules(){
        $page_title =  $this->page_title . ' - ' .__('Modules');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Modules' => '',
                'Edit' => ''
            ];
        $pageTitle = 'modules';
        $modules = Module::all()->sortBy('name');
        return view('site.modules',compact('page_title','breadcrumb','modules','pageTitle'));
    }

    /**
     * Modules status update
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateModules(Request $request){

        if ($request->isMethod('PUT')){
            $modules= Module::all();
            $updated_modules = $request->input()['modules'];
            foreach ($modules as $module){
                $updated_module_item = Module::find($module->id);
                if (array_key_exists($module->id,$updated_modules)){
                    if ($updated_module_item->status != 1){
                        $updated_module_item->update([
                            'status' => Module::STATUS_ENABLED
                        ]);
                    }
                }else{
                    if ($updated_module_item->status == 1){
                        $updated_module_item->update([
                            'status' => Module::STATUS_DISABLED
                        ]);
                    }
                }
            }
            session()->flash('success','modules updated');
            return redirect()->back();
        }

    }

}
