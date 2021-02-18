<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Modules\Course\Lesson;
use App\Modules\Form\Form;
use App\Modules\Form\FormItem;
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

    public function getItem(Form $form){
        $groups = array();
        if ($form){
            $displayType = !is_null($form->properties['display_type']) ? $form->properties['display_type'] : 1;
            $formItems = $form->getGroupedItems();
            foreach ($formItems as $section => $items){
                $group = FormItem::getGroupSection($items);
                $questionsToAnswer = isset($group->properties['allowed_number']) ?  $group->properties['allowed_number'] : null;
                $items = FormItem::getItemsWithShuffleStatus($items);
                $itemsArray = array();
                $count = 0;
                $groupDraggableBlanks = [];
                foreach ($items as $key => $item){
                    $blanksArray = array();
                    if ($item->type == FormItem::TYPE_FILL_THE_BLANK || $item->type == FormItem::TYPE_FILL_THE_BLANK_DRAG_AND_DROP){
                        $item->blank_paragraph = $item->getFillableBlank($item->id);
                    }
                    if ($item->type == FormItem::TYPE_FILL_THE_BLANK_DRAG_AND_DROP){
                        $blanks = !empty($item->options) && !empty($item->options['paragraph_blanks']) ? $item->options['paragraph_blanks'] : array();
                        foreach ($blanks as $blank){
                            foreach ($blank['items'] as $blankItem){
                                array_push($blanksArray, $blankItem['value']);
                            }
                        }
                        $array2 = $blanksArray;
                        shuffle($array2);
                        $blanksArray = $array2;

                        // group draggable blanks
                        foreach ($blanksArray as $draggableBlankItem) {
                            $groupDraggableBlanks[] = [
                                'id' => rand(0,999),
                                'value' => $draggableBlankItem,
                                'question_id' => $item->id,
                            ];
                        }

                    }

                    $item->blanks = $blanksArray;
                    $item->dropped_blanks = array();
                    $item->auto_leave = !empty($questionsToAnswer) && $questionsToAnswer < $key;
                    $item->review = false;
                    // add to items array
                    if ($item->type != FormItem::TYPE_SECTION){
                        $count++;
                        $itemsArray[$count] = $item;
                    }
                }

                $array3 = $groupDraggableBlanks;
                shuffle($array3);
                $groupDraggableBlanks = $array3;

                $groups[] = [
                    'id' => !empty($group) ? $group->id : null,
                    'title' => !empty($group) ? $group->title : null,
                    'description' => !empty($group) ? $group->description : null,
                    'dropped_blanks' => array(),
                    'score' => !empty($group) ? $group->score : null,
                    'items' => $itemsArray,
                    'draggable_blanks' => $groupDraggableBlanks,
                ];
            }
            $form->grouped_questions = $groups;
            $form->display_type = $displayType;
            $form->direction = $form->getDirection();
            $form->has_time_limit = !empty($form->properties['has_time_limit']);
            $form->time_limit = !empty($form->properties['time_limit'])? $form->properties['time_limit'] : null;
            return response($form, 200);
        }

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
