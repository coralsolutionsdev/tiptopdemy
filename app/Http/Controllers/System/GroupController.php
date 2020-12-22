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
        $input = $request->only('title');
        $input['status'] = 1;
        $input['type'] = Group::TYPE_FILE_MANAGER;
        $group = $model->createGroup($input);
        $date = [
            'title' => $group->title,
            'slug' => $group->slug
        ];
        return response($date, 200);
    }

    public function ajaxGetIndex($type)
    {
        if (empty($type)){
            return response('error',503);
        }

        $groups = getAuthUser()->getGroupsWithType($type)->map(function ($item) {
            return $item->only(['title', 'slug']);
        })->toArray();
        return response($groups, 200);
    }
}
