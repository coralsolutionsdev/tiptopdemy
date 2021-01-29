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
//        return ProductsResource::collection($items);

    }
    public function getItems(Lesson $lesson)
    {
        $items = $lesson->getFormsWithType(Form::TYPE_MEMORIZE);
        $items->map(function ($form)  {
            $groupedAnswers = $form->items->groupBy('type');
            $answersArr = [];
            $typeArray = [];
            foreach ($groupedAnswers as $group => $answers){
                $groupCorrectAnswersCount = 0;
                $titlesArray = [];
                $propertiesArrays = [];

                if ($answers->count() > 0 && $form->isGroupTypeEnabled($group)){ // have answers
                    // first correct answer
                    $firstCorrectAnswer = $answers->where('status', 1)->first();
                    if (!empty($firstCorrectAnswer)){
                        $groupCorrectAnswersCount++;
                        $answersArr[$group][] = [
                            'id' => $firstCorrectAnswer->id,
                            'title' => $firstCorrectAnswer->title,
                            'status' => 1,
                            'media_url' => !empty($firstCorrectAnswer->properties) && !empty($firstCorrectAnswer->properties['media_url']) ? $firstCorrectAnswer->properties['media_url'] : null,
                        ];
                        array_push($titlesArray, $firstCorrectAnswer->title);
                        array_push($propertiesArrays, $firstCorrectAnswer->properties);
                        // two wrong answers
                        $wrongAnswers = collect();
                        if ($answers->where('status', 0)->count() > 1){
                            $wrongAnswers = $answers->where('status', 0)->random(2);
                        }elseif ($answers->where('status', 0)->count() == 1){
                            $wrongAnswers = $answers->where('status', 0)->random(1);
                        }

                        foreach ($wrongAnswers as $answer){
                            $answersArr[$group][] = [
                                'id' => $answer->id,
                                'title' => $answer->title,
                                'status' => 0,
                                'media_url' => !empty($answer->properties) && !empty($answer->properties['media_url']) ? $answer->properties['media_url'] : null,
                            ];
                            array_push($titlesArray, $answer->title);
                            array_push($propertiesArrays, $answer->properties);
                        }
                        // external wrong answer
                        $randomItemsCount = 3 - $wrongAnswers->count();
                        if ($group == 20 || $group == 21){
                            $randomAnswers = FormItem::where('type', $group)->where('form_id', '!=', $form->id )->whereNotIn('title', $titlesArray)->inRandomOrder()->limit($randomItemsCount)->get();
                        }else{
                            $randomAnswers = FormItem::where('type', $group)->where('form_id', '!=', $form->id )->whereNotIn('properties', $propertiesArrays)->inRandomOrder()->limit($randomItemsCount)->get();
                        }
                        if (!empty($randomAnswers)){
                            foreach ($randomAnswers as $answer){
                                $answersArr[$group][] = [
                                    'id' => $answer->id,
                                    'title' => $answer->title,
                                    'status' => 0,
                                    'media_url' => !empty($answer->properties) && !empty($answer->properties['media_url']) ? $answer->properties['media_url'] : null,
                                ];
                            }
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
        $itemsArray = [];
        foreach ($items as $formItem){
            $itemsArray[] = [
                'id' => $formItem->id,
                'title' => $formItem->title,
                'description' => $formItem->description,
                'properties' => $formItem->properties,
                'answers' => $formItem->answers,
                'type_array' => $formItem->type_array,
            ];
        }

        return response($itemsArray, 200);
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
