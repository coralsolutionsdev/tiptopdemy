<?php

namespace App\Http\Controllers\Site;

use App\Role;
use App\Services\FileAssetManagerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
    $this->middleware('auth');
        $this->page_title = 'Users';
        $this->breadcrumb = [
            'Users' => '',
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
        $users = User::latest()->paginate(5);
        $current_user = Auth::user();
        $roles = Role::all()->filter(function ($role) use ($current_user){
            if ($role->name == 'superadministrator'){
                if ($current_user->hasRole('superadministrator')){
                    return true;
                }
                return false;
            }
            return true;
        });
        return view('user.index', compact('page_title','breadcrumb','users','roles','current_user'));
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => 'required|bool',
            'role' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $data = $request->input();
        if($data['gender'])
        { $avatar = 'male.png';}
        else
        { $avatar = 'female.png'; }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'lang' => 'ar',
            'avatar' => $avatar,
            'password' => bcrypt($data['password']),
            'verify_token' => str_random(60),
        ]);

        //role assign
        $current_user = Auth::user();
        $updated_role = Role::where('id',$request->input('role'))->first();
        if ($updated_role->name == 'superadministrator'){
            if ($current_user->hasRole('superadministrator')){
                $user->attachRole($updated_role);
            }
        }else{
            $user->attachRole($updated_role);
        }
        session()->flash('success','user created successfully');
        return redirect()->back();
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
        $user = User::find($id);
        return view('user.show', compact('user'));
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
        $user = User::find($id);
        $current_user = Auth::user();
        $roles = Role::all()->filter(function ($role) use ($current_user){
            if ($role->name == 'superadministrator'){
                if ($current_user->hasRole('superadministrator')){
                    return true;
                }
                return false;
            }
            return true;
        });
        $genders = User::GENDER_ARRAY;
        return view('user.edit', compact('page_title','breadcrumb','user','roles','genders'));
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

            $user = User::find($id);
            // validate only if email changed
            if($user->email != $request->input('email')){
                $this->validate($request, [
                'email' => 'required|string|email|max:255|unique:users',
                ]);

            }
             $this->validate($request, [
                'name' => 'required|string|max:255',
                'gender' => 'required|bool',
            ]);
            $input = $request->input();
            $current_user = Auth::user();
            $updated_role = Role::where('id',$request->input('role'))->first();
            $user_role = $user->roles()->first();
            //role update
            if ($user_role->id != $updated_role->id){
                if ($updated_role->name == 'superadministrator'){
                    if ($current_user->hasRole('superadministrator')){
                        $user->detachRole($user_role);
                        $user->attachRole($updated_role);
                    }
                }else{
                    $user->detachRole($user_role);
                    $user->attachRole($updated_role);
                }
            }
            if(!empty($input['status'])){
                $status = 1;
            }else{
                $status = 0;
            }
            $input['status'] = $status;
            if ($request->hasFile('image')) {
                // upload and save image
                $image = $request->file('image');
                $location =  config('baseapp.user_image_storage_path');
                $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                $input['avatar'] = $uploaded_image;
                // Delete old image
                FileAssetManagerService::ImageDestroy($user->avatar);
            }
            $user->update($input);

            session()->flash('success','The user has been succefully updated!');
            return redirect()->route('users.index');
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
        $user = User::find($id);
        $user->delete();
        session()->flash('success','User has been succefully deleted!');
        return redirect()->route('users.index');

    }

    /* password update */

    public function PassEdit($id){
        $user = User::find($id);
        return view('user.password', compact('user'));
    }

     public function PassUpdate(Request $request, $id){
        if ($request->isMethod('PUT')){

            $user = User::find($id);
            $oldpassword = $user->password;

            $this->validate($request, [
                'password'      => 'required|string|confirmed',
                ]);

           // if(Hash::check($oldpassword,$request->input('password')))
                $user->password = Hash::make($request->input('password'));
                $user->save();
                session()->flash('success','The user has been succefully updated!');
                return redirect()->route('users.show',$user->id);
          


        }
        
    }

    /* Role update*/
    public function RoleEdit($id){
        $user = User::find($id);
        return view('user.role', compact('user'));
    }

    public function RoleUpdate(Request $request, $id){
        if ($request->isMethod('PUT')){

             $user = User::find($id);
             $this->validate($request, [
                'role' => 'required',
                ]);
            $user->role = $request->input('role');
            $user->save();
            session()->flash('success','The user role has been succefully updated!');
            return redirect()->route('users.show',$user->id);

        }

    }
}
