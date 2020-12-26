<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Modules\Group\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStore(Request $request)
    {
        $model = getAuthUser();
        $input = $request->only(['title', 'ancestor_slug']);
        $ancestorSlug = $input['ancestor_slug'];
        $ancestor = Group::where('slug', $ancestorSlug)->first();
        $input['ancestor_id'] = !empty($ancestor) ? $ancestor->id : null;
        $input['status'] = 1;
        $input['type'] = Group::TYPE_FILE_MANAGER;
        $group = $model->createGroup($input);

        $date = [
            'title' => $group->title,
            'slug' => $group->slug,
            'sub_groups' => 0,
            'ancestor_slug' => $ancestorSlug,
            'items_count' => 0,
        ];
        return response($date, 200);
    }

    public function ajaxGetIndex(Request $request, $type)
    {
        $input = $request->only(['ancestor_slug']);
        $ancestorSlug = $input['ancestor_slug'];
        $ancestor = Group::where('slug', $ancestorSlug)->first();
        $ancestorId = !empty($ancestor) ? $ancestor->id : null;

        if (empty($type)){
            return response('error',503);
        }
        $groups = getAuthUser()->getGroupsWithType($type)->filter(function ($group) use($ancestorId){
            if ($group->ancestor_id == $ancestorId){
                return true;
            }
            return false;
        })->map(function ($item) {
            $subGroups = Group::where('ancestor_id', $item->id)->get();
            $ancestor = Group::find($item->ancestor_id);
            $item->items_count = $item->mediaItems()->count();
            $item->sub_groups = !empty($subGroups) ? $subGroups->count() : 0;
            $item->ancestor_slug = !empty($ancestor) ? $ancestor->slug : null;
            $item->ancestor_title = !empty($ancestor) ? $ancestor->title : null;
            return $item->only(['title', 'slug', 'items_count', 'sub_groups', 'ancestor_slug', 'ancestor_title']);
        })->toArray();
        return response($groups, 200);
    }
}
