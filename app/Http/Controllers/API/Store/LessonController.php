<?php

namespace App\Http\Controllers\API\Store;

use App\Http\Controllers\Controller;
use App\Modules\Course\Lesson;
use App\Modules\Form\FormItem;
use App\Modules\Form\FormResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function getItems(Lesson $lesson)
    {
        $content = !empty($lesson->content) && !empty($lesson->content['html']) ? $lesson->content['html'] : '';
        $description = !empty($lesson->description) ? $lesson->description : '';
        $resources = !empty($lesson->resources) ? $lesson->resources : array();
        $forms = $lesson->getAvailableForms();
        $formsArray = [];
        if (!empty($forms)){
            foreach ($forms as $form){
                $evaluationStatus = 0;
                $evaluationMark = 0;
                $responseLink = '';
                if (!empty($form->getLastResponse()) && $form->getLastResponse()->status == FormResponse::STATUS_FULLY_EVALUATED){
                    $evaluationStatus = 1;
                    $evaluationMark = $form->getLastResponse()->score_info['achieved_score'].'/'.$form->getLastResponse()->score_info['total_score'];
                    $responseLink = route('form.response.show', $form->getLastResponse()->hash_id);
                }
                $formsArray[] = [
                    'title' => $form->title,
                    'description' => $form->description,
                    'items_count' => $form->items->where('type', '!=', FormItem::TYPE_SECTION)->count(),
                    'has_time_limit' => !empty($form->properties['has_time_limit']) && $form->properties['has_time_limit'] == 1 ? 1 : 0,
                    'time_limit' => $form->properties['time_limit'].' '.trans_choice('main.Minutes', $form->properties['time_limit']),
                    'evaluation_status' => $evaluationStatus,
                    'evaluation_mark' => $evaluationMark,
                    'response_link' => $responseLink,
                    'form_url' => route('store.form.show',[$lesson->slug, $form->hash_id]),
                ];
             }
        }

        return response([
            'content' => $content,
            'description' => $description,
            'resources' => $resources,
            'forms' => $formsArray
        ], 200);
    }
}
