<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class Products extends JsonResource
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
            'name' => $this->name,
            'sku' => $this->sku,
            'price' => $this->price,
            'link' => $this->link,
            'primary_image' => $this->primary_image,
            'alternative_image' => $this->alternative_image,
            'sub_description' => $this->sub_description,
            'user_name' => $this->user_name,
            'user_profile_pic' => $this->user_profile_pic,
            'has_purchased' => $this->has_purchased,
            'in_cart' => $this->in_cart,

        ];
    }
}
