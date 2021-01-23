<?php

namespace App\Http\Controllers\API\Form;

use App\Http\Controllers\Controller;
use App\Http\Resources\Form\FormItem as FormItemResource;
use App\Modules\Course\Lesson;
use App\Modules\Form\Form;
use App\Modules\Form\FormItem;
use App\Product;
use Illuminate\Http\Request;

class MemorizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->only('id');
        $items = FormItem::where('type', Form::TYPE_MEMORIZE)->latest()->paginate(15);
        $items->map(function ($item){
            $item->creator_name = ucfirst($item->creator->name);
            $item->creation_date = $item->created_at->toFormattedDateString();
        });
        return response('mehmet', 200);
//        return FormItemResource::collection($items);

    }
    public function getItems(Lesson $lesson)
    {
        $items = $lesson->getFormsWithType(Form::TYPE_MEMORIZE);
        $items->map(function ($form){
            $answers = $form->items->groupBy('type');
            $answersArr = [];
            $typeArray = [];
            foreach ($answers as $group => $answers){
                $answersCount = 0;
                $groupCorrectAnswersCount = 0;
                $groupCorrectAnswerId = null;
                if ($answers->count() > 0){ // have answers
                    foreach ($answers as $answer){
                        // inside group answers
                        if ($answer->status == 1 && empty($groupCorrectAnswerId)){
                            $groupCorrectAnswerId = $answer->id;
                            $groupCorrectAnswersCount++;
                        }
                        if ($answer->status == 0 || (!empty($groupCorrectAnswerId) && $answer->id == $groupCorrectAnswerId)){
                            $answersArr[$group][] = [
                                'id' => $answer->id,
                                'title' => $answer->title,
                                'status' => $answer->status,
                                'media_url' => !empty($answer->properties) && !empty($answer->properties['media_url']) ? $answer->properties['media_url'] : null,
                            ];
                            $answersCount++;
                        }


                    }
                    if ($answersCount < 4 && $groupCorrectAnswersCount > 0){
                        $randomItemsCount = 4 - $answersCount;
                        $randomAnswers = FormItem::where('type', $group)->where('form_id', '!=', $form->id )->where('status', 0)->inRandomOrder()->limit($randomItemsCount)->get();
                        foreach ($randomAnswers as $answer){
                            $answersArr[$group][] = [
                                'id' => $answer->id,
                                'title' => $answer->title,
                                'status' => $answer->status,
                                'media_url' => !empty($answer->properties) && !empty($answer->properties['media_url']) ? $answer->properties['media_url'] : null,
                            ];
                        }
                    }
                    if ($groupCorrectAnswersCount > 0){
                        $typeArray[] = $group;
                    }
                }

            }
            $form->answers = $answersArr;
            $form->type_array = $typeArray;
        });
//        dd($items);
        return response($items, 200);
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
}
