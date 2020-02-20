<?php
/**
 * By Mehmet
 * 21 April 2018
 */
namespace App\Http\Controllers\Site;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Access rights';
        $this->breadcrumb = [
            'Access rights' => ''
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
        $pageTitle ='Roles';
        $roles = Role::all();
        return view('access.roles.index',compact('page_title','breadcrumb','pageTitle','roles'));
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

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function editRolePermissions($id){

        $pageTitle = 'Assign Permissions';
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('access.roles.edit-permissions',compact('pageTitle','role','permissions'));
    }
    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function updateRolePermissions(Request $request, $id){
        $role = Role::find($id);
        $updated_permissions = array();
        if (!empty($request->input()['permissions'])){
            $updated_permissions = $request->input()['permissions'];
        }
        $all_permissions = Permission::all();
        // All permissions
        foreach ($all_permissions as $permission){
            // check if permission selected
            if (array_key_exists($permission->id,$updated_permissions) AND !empty($request->input()['permissions'])){
                // if the role don't have this permission, attach it
                if (!$role->permissions->contains($permission->id)){
                    $role->attachPermission($permission->id);
                }
            }else{
                // if the role have this permission, remove it it
                if ($role->permissions->contains($permission->id)){
                    $role->detachPermission($permission->id);
                }
            }
        }
        session()->flash('success','Permissions updated successfully');
        return redirect()->route('roles.index');
    }

}
