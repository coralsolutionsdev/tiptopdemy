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
        $ancestorSlug = isset($input['ancestor_slug']) ? $input['ancestor_slug'] : null;
        $ancestor = Group::where('slug', $ancestorSlug)->first();
        $ancestorId = !empty($ancestor) ? $ancestor->id : null;
        $items = array();
        if (empty($type)){
            return response('error',503);
        }
        $groups = getAuthUser()->getGroupsWithType($type)->sortByDesc('created_at')->filter(function ($group) use($ancestorId){
            if ($group->ancestor_id == $ancestorId){
                return true;
            }
            return false;
        })->map(function ($item) {
            $subGroups = Group::where('ancestor_id', $item->id)->get()->map(function ($subgroup){
                return $subgroup->only(['title', 'slug']);
            });
            $ancestor = Group::find($item->ancestor_id);
            $item->items_count = $item->mediaItems()->count();
            $item->sub_groups = !empty($subGroups) ? $subGroups : null;
            $item->sub_groups_count = !empty($subGroups) ? $subGroups->count() : 0;
            $item->ancestor_slug = !empty($ancestor) ? $ancestor->slug : null;
            $item->ancestor_title = !empty($ancestor) ? $ancestor->title : null;
            return $item->only(['id','title', 'slug', 'items_count', 'sub_groups', 'sub_groups_count','ancestor_slug', 'ancestor_title']);
        })->toArray();
        return response($groups, 200);
    }
    public function ajaxUpdate(Request $request){
        $input = $request->only(['id', 'title', 'group_slug']);

        if (isset($input['id'])){
            $currentGroup = Group::find($input['id']);
            if (!empty($currentGroup)){
                $parentGroup = isset($input['group_slug']) ? Group::where('slug', $input['group_slug'])->first() : null;
                $input['ancestor_id'] = !empty($parentGroup) ? $parentGroup->id : null;
                $input['title'] = isset($input['title']) && !empty($input['title']) && $input['title'] != null ? $input['title'] : $currentGroup->title;
                $currentGroup->update($input);
                return response('success', 200);
            }
            return response('current group un available', 503);
        }
        return response('error', 503);
    }

}
