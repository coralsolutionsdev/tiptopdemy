<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comments extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'likes' => $this->likes,
            'commenter_user_id' => $this->commenter_user_id,
            'commenter_name' => $this->commenter_name,
            'commenter_profile_pic' => $this->commenter_profile_pic,
            'creation_date' => $this->creation_date,
            'is_liked' => $this->is_liked,
            'commenter_gender' => $this->commenter_gender,
            'parent_id' => $this->parent_id,
            'sub_comments' => $this->sub_comments,
            'replayMode' => $this->replayMode,
        ];
    }
}
