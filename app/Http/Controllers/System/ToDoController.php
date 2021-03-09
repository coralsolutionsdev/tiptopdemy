<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Modules\System\ToDo;
use App\Modules\System\TodoItem;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;
use App\Http\Resources\System\ToDo as ToDoResource;


class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $user = getAuthUser();
        if (!$user){
            abort(500);
        }
        $items = $user->todos()->paginate(25);
        $items->map(function ($item){
            $item->completed = $item->status == 1;
        });
        return ToDoResource::collection($items);
        return response(array(), 200);

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
        $input = $request->all();
        $user = getAuthUser();
        if (empty($user)){
            return response('', 500);
        }
        $input['status'] = 0;
        $input['creator_id'] = $user->id;
        $input['editor_id'] = $user->id;
        $todo = TodoItem::create($input);
        return response($todo,200);
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
     * @param \Illuminate\Http\Request $request
     * @param ToDo $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDo $todo)
    {
        $input = $request->only(['title', 'status']);
        $input['title'] = !empty($input['title']) ? $input['title'] : $todo->title;
        $todo->update($input);
        return response('success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ToDo $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDo $todo)
    {
        if (!empty($todo)){
            $todo->delete();
        }
        return response('success', 200);
    }
}
