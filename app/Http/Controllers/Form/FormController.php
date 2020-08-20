<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Modules\Course\Lesson;
use App\Modules\Form\Form;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormController extends Controller
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
        $input =  $request->all();
        $input['type'] = Form::TYPE_FORM;
        $owner = Form::getOwner($input['owner_id'], $input['owner_type']);
        $form = Form::createOrUpdate($input, $owner);
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('store.form.edit', [$owner->slug, $form->slug]);
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
     * @param Form $form
     * @return Application|ResponseFactory|Response
     */
    function getItems(Form $form){
        $items = $form->items;
        return response($items, 200);
    }
}
