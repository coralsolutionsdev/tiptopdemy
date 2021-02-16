<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Modules\Course\Lesson;
use App\Modules\Form\Form;
use App\Modules\Form\FormItem;
use App\Modules\Form\FormResponse;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ResponseController extends Controller
{
    protected $modelName;
    protected $page_title;
    protected $breadcrumb;

    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['show']]);
        $this->page_title = 'Quizzes';
        $this->modelName = 'Quizzes';
    }
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
     * @param \Illuminate\Http\Request $request
     * @param Form $form
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Form $form)
    {
        $input = $request->only(['item_id', 'item_answer', 'item_leave', 'lesson_id']);
        dd($input);
        $lesson = Lesson::find($input['lesson_id']);
        if (empty($lesson)){
            // message
            return redirect()->back();
        }
        $inputIds = isset($input['item_id']) ? $input['item_id'] : null;
        $inputAnswers = isset($input['item_answer']) ? $input['item_answer'] : null;
        $inputLeaveQuestions = isset($input['item_leave']) ? $input['item_leave'] : null;
        $newItemInput['status'] = FormResponse::STATUS_FULLY_EVALUATED;
        $data =  array();
        $section = 0; // default
        $responseTotalScore = 0;
        $responseAchievedTotalScore = 0;
        $sectionEvaluationTypeArray[0] = FormResponse::EVALUATION_TYPE_AUTO;
        if (is_null($inputIds)){
            // message
            return back();
        }
        foreach ($inputIds as $id){
            $formItem = FormItem::find($id);
            $itemType = $formItem->type;
            $itemDefaultAnswers = $formItem->getDefaultAnswers();
            $itemInputAnswer = !empty($inputAnswers) && isset($inputAnswers[$id]) ? $inputAnswers[$id] : '';
            $itemAnswersArray = array(); // default as empty
            $ItemTotalAnswerScore = 0;
            if (!empty($formItem)){
                // Answers evaluation:
                if (!empty($inputLeaveQuestions) && in_array($id, $inputLeaveQuestions)){ // evaluation not required
                    // toDo: build answers array
                }else{ //evaluation is required
                    // question type
                    if ($itemType ==  FormItem::TYPE_SECTION){ // section
                        $section++;
                        $sectionEvaluationTypeArray[$section] = FormResponse::EVALUATION_TYPE_AUTO; // default auto evaluation
                        if (!empty($formItem->properties['evaluation']) && $formItem->properties['evaluation'] == FormResponse::EVALUATION_TYPE_MANUAL){
                            $newItemInput['status'] = FormResponse::STATUS_PARTIALLY_EVALUATED;
                            // answers array is empty
                            $sectionEvaluationTypeArray[$section] = FormResponse::EVALUATION_TYPE_MANUAL;
                        }
                    } else { // not section
                        $responseTotalScore = $responseTotalScore + $formItem->score;

                        if ($itemType ==  FormItem::TYPE_PARAGRAPH){
                            $input['status'] = FormResponse::STATUS_PARTIALLY_EVALUATED;
                            // $itemEvaluatedStatus = FormResponse::EVALUATION_STATUS_PENDING;
                            // TODO: build answers array
                        } elseif (in_array($itemType, [FormItem::TYPE_SHORT_ANSWER, FormItem::TYPE_SINGLE_CHOICE, FormItem::TYPE_DROP_DOWN, FormItem::TYPE_MULTI_CHOICE])){

                            if (!empty($itemInputAnswer)){ // check if item have answers
                                $itemAnswerStatus = FormResponse::EVALUATION_STATUS_PENDING; // default evaluation status correct
                                $itemScore = $formItem->score; // default evaluation score
                                // item answers
                                // evaluation
                                if (!is_array($itemInputAnswer)){
                                    $itemInputAnswerArray = [$itemInputAnswer];
                                }else{
                                    $itemInputAnswerArray = $itemInputAnswer;
                                }
                                foreach ($itemInputAnswerArray as $itemInputAnswerValue){
                                    $ItemAnswerScore = 0;
                                    $itemAnswerStatus = FormResponse::EVALUATION_STATUS_PENDING; // evaluation status correct
                                    if ($sectionEvaluationTypeArray[$section] == FormResponse::EVALUATION_TYPE_AUTO){ // check if evaluation is auto
                                        $itemAnswerStatus = FormResponse::EVALUATION_STATUS_WRONG; // evaluation status correct
                                        if (!empty($itemDefaultAnswers)){ // have default answers
                                            foreach ($itemDefaultAnswers as $defaultAnswer){
                                                $valueToLower = strtolower($defaultAnswer['value']);
                                                $defaultAnswerToLower = strtolower($itemInputAnswerValue);
                                                if ($valueToLower == $defaultAnswerToLower){
                                                    $itemAnswerStatus = FormResponse::EVALUATION_STATUS_CORRECT; // evaluation status correct
                                                    $ItemAnswerScore = $defaultAnswer['score']; // evaluation score
                                                    $ItemTotalAnswerScore = $ItemTotalAnswerScore + $ItemAnswerScore; // evaluation score
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    // answers array (add to answer array)
                                    $itemAnswersArray[] = [
                                        'value' => $itemInputAnswerValue,
                                        'status' => $itemAnswerStatus,
                                        'score' => $ItemAnswerScore,
                                    ];
                                }

                            }
                        } elseif (in_array($itemType, [FormItem::TYPE_FILL_THE_BLANK])){
                            if (!empty($itemInputAnswer)){ // check if item have answers
                                $itemScore = $formItem->score; // default evaluation score
                                $defaultAnswers = $formItem->getDefaultAnswers(FormItem::TYPE_FILL_THE_BLANK);
                                // item answers
                                // evaluation
                                if (!is_array($itemInputAnswer)){
                                    $itemInputAnswerArray = [$itemInputAnswer];
                                }else{
                                    $itemInputAnswerArray = $itemInputAnswer;
                                }
                                foreach ($itemInputAnswerArray as $answerKey => $itemInputAnswerValue){
                                    $ItemAnswerScore = 0;
                                    $itemAnswerStatus = FormResponse::EVALUATION_STATUS_PENDING; // evaluation status correct
                                    if ($sectionEvaluationTypeArray[$section] == FormResponse::EVALUATION_TYPE_AUTO){ // check if evaluation is auto
                                        $itemAnswerStatus = FormResponse::EVALUATION_STATUS_WRONG; // evaluation status correct
                                        if (!empty($defaultAnswers)){ // have default answers
                                            if (!empty($defaultAnswers[$answerKey])){
                                                $blankItems = $defaultAnswers[$answerKey]['items'];
                                                foreach ($blankItems as $blankItem){
                                                    $itemInputAnswerValueToLower = strtolower($itemInputAnswerValue);
                                                    $blankItemValueToLower = strtolower($blankItem['value']);
                                                    if ($itemInputAnswerValueToLower == $blankItemValueToLower){
                                                        $itemAnswerStatus = FormResponse::EVALUATION_STATUS_CORRECT; // evaluation status correct
                                                        $ItemAnswerScore = $blankItem['score']; // evaluation score
                                                        $ItemTotalAnswerScore = $ItemTotalAnswerScore + $ItemAnswerScore; // evaluation score
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    // answers array (add to answer array)
                                    $itemAnswersArray[] = [
                                        'value' => $itemInputAnswerValue,
                                        'status' => $itemAnswerStatus,
                                        'score' => $ItemAnswerScore,
                                    ];

                                }
                            }
                        }
                    }
                    // update total achieved score
                    $responseAchievedTotalScore = $responseAchievedTotalScore + $ItemTotalAnswerScore;
                    // add to data array
                    $data[$section][] = [
                        'id' => $formItem->id,
                        'title' => $formItem->title,
                        'description' => $formItem->description,
                        'answers' => $itemAnswersArray,
                        'type' => $formItem->type,
                        'score' => $formItem->score,
                        'evaluation_score' => $ItemTotalAnswerScore,
                        'properties' => $formItem->properties,
                    ];

                }
            }

        }
        // response score info
        $scorePercentage = ($responseAchievedTotalScore/$responseTotalScore) * 100;
        $scoringType = !empty($form->properties['score_type']) ? $form->properties['score_type'] : 1;
        $passingScore = !empty($form->properties['passing_score']) ? $form->properties['passing_score'] : 50;
        $scoreStatus = FormResponse::PASSING_STATUS_FAILED; // failed
        if ($scoringType == 1){ //percentage
            if ($scorePercentage >= $passingScore){
                $scoreStatus = FormResponse::PASSING_STATUS_PASSED;
            }
        } elseif ($scoringType == 2) { //score
            if ($responseAchievedTotalScore >= $passingScore){
                $scoreStatus = FormResponse::PASSING_STATUS_PASSED;
            }
        }
        $scoreInfo = [
            'total_score' => $responseTotalScore,
            'achieved_score' => $responseAchievedTotalScore,
            'score_percentage' => round($scorePercentage,1),
            'passing_score_status' => $scoreStatus,
            'passing_score_type' => $scoringType,
            'passing_score_score' => $passingScore,
        ];
        //
        $newItemInput['title'] = $form->title;
        $newItemInput['description'] = $form->description;
        $newItemInput['form_id'] = $form->id;
        $newItemInput['ancestor_id'] = $form->ancestor_id;
        $newItemInput['data'] = $data;
        $newItemInput['type'] = 1; // default Unknown
        $newItemInput['properties'] = $form->properties;
        $newItemInput['score_info'] = $scoreInfo;
        $newItemInput['creator_id'] = getAuthUser() ? getAuthUser()->id : null;
        $response = FormResponse::create($newItemInput);
        $response->hash_id = Hashids::encode(1,$lesson->id,$response->id);
        $response->save();
        session()->flash('success', trans('main.Quiz has been submitted successfully'));
        return redirect()->route('store.lesson.show',[$lesson->product->slug, $lesson->slug]);

    }

    /**
     * @param Request $request
     * @param Form $form
     */
    public function ajaxStore(Request $request, Form $form){
        $input = $request->only(['answers']);
        $response = $form->createResponse($input['answers']);

        $response->score_info['passing_score_status'];
        $passingScoreType = $response->score_info['passing_score_type'];
        if ($passingScoreType == 1){
            $score = $response->score_info['score_percentage'].' / 100 %';
        }else{
            $score = $response->score_info['achieved_score'].' / '.$response->score_info['total_score'];

        }
        $responseArray = [
            'status' => $response->status,
            'passing_score_status' => $response->score_info['passing_score_status'],
            'passing_type' => $passingScoreType,
            'score' => $score,
            'link' => route('form.response.show',  $form->getLastResponse()->hash_id),
        ];
        return response($responseArray, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param FormResponse $response
     * @return void
     */
    public function show(FormResponse $response)
    {
        $modelName = $this->modelName;
        $page_title = $response->title;
        $displayType = !is_null($response->properties['display_type']) ? $response->properties['display_type'] : 1;
        return view('forms.response.show', compact('modelName', 'page_title', 'response', 'displayType'));

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
