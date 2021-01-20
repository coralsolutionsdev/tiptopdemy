<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Modules\Group\Group;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function ajaxStore(Request $request)
    {
        $model = getAuthUser();
        $input = $request->only(['title', 'parent_slug']);
        $ancestorSlug = $input['parent_slug'];
        $parentGroup = Group::where('slug', $ancestorSlug)->first();
        $parentGroupId = !empty($parentGroup) ? $parentGroup->id : null;
        $parentGroupAncestorId = !empty($parentGroup) ? $parentGroup->ancestor_id : null;
        $input['parent_id'] = $parentGroupId;
        $input['ancestor_id'] = !empty($parentGroupAncestorId) ? $parentGroupAncestorId : $parentGroupId;
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

    /**
     * @param Request $request
     * @param $type
     * @return Application|ResponseFactory|Response
     */
    public function ajaxGetIndex(Request $request, $type)
    {
        $input = $request->only(['parent_slug']);
        $parentSlug = isset($input['parent_slug']) ? $input['parent_slug'] : null;
        $parent = Group::where('slug', $parentSlug)->first();
        $parentParent = !empty($parent) ? Group::find($parent->parent_id) : null;
        $prevGroup = [
            'slug' => !empty($parentParent) ? $parentParent->slug : null,
            'title' => !empty($parentParent) ? $parentParent->title : 'Files',
        ];
        $parentId = !empty($parent) ? $parent->id : null;
        $items = array();
        if (empty($type)){
            return response('error',503);
        }
        $groups = getAuthUser()->getGroupsWithType($type)->sortBy('title')->filter(function ($group) use($parentId){
            if ($group->parent_id == $parentId){
                return true;
            }
            return false;
        });
        foreach ($groups as $group){
            $subGroups = Group::where('parent_id', $group->id)->get()->map(function ($subgroup){
                return $subgroup->only(['title', 'slug']);
            });
            $parent = Group::find($group->parent_id);
            $items[] = [
                'id' => $group->id,
                'title' => $group->title,
                'slug' => $group->slug,
                'items_count' => $group->mediaItems()->count(),
                'sub_groups' => !empty($subGroups) ? $subGroups : null,
                'sub_groups_count' => !empty($subGroups) ? $subGroups->count() : 0,
//                'parent_slug' => !empty($parent) ? $parent->slug : null,
//                'parent_title' => !empty($parent) ? $parent->title : null,
            ];
        }
        return response(['groups' => $items, 'prevGroup' => $prevGroup], 200);
    }
    public function ajaxUpdate(Request $request){
        $input = $request->only(['id', 'title', 'group_slug']);

        if (isset($input['id'])){
            $currentGroup = Group::find($input['id']);
            if (!empty($currentGroup)){
                $parentGroup = isset($input['group_slug']) ? Group::where('slug', $input['group_slug'])->first() : null;
                $parentGroupId = !empty($parentGroup) ? $parentGroup->id : null;
                if ($parentGroupId == $currentGroup->id){
                    return response('Cannot move the folder inside itself', 400);
                }
                $input['parent_id'] = $parentGroupId;
                $input['title'] = isset($input['title']) && !empty($input['title']) && $input['title'] != null ? $input['title'] : $currentGroup->title;
                $currentGroup->update($input);
                return response('success', 200);
            }
            return response('current group un available', 503);
        }
    }

    /**
     * @param $id
     * @param $type
     * @return Application|ResponseFactory|Response
     */
    public function ajaxDestroy($id, $type)
    {
        // TODO: check if use can remove this media item
        $user = getAuthUser();
        $groups = Group::where('id', $id)->orWhere('ancestor_id', $id)->get();
        if (!empty($user) && $groups){
            foreach ($groups as $group){
                if ($type == 1){
                    $groupSlug = $group->slug;
                    $mediaItems = $user->getMedia('file_manager')->sortByDesc('created_at')->filter(function ($mediaItem) use($groupSlug){
                        if ($mediaItem->getCustomProperty('group') == $groupSlug){
                            return true;
                        }
                        return false;
                    });
                    if (!empty($mediaItems)){
                        foreach ($mediaItems as $media){
                            $media->delete();
                        }
                    }
                    $group->delete();
                }
            }
            return response('success', 200);

        }
        return response('error', 503);

    }

}
