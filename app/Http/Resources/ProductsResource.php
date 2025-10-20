<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
     
        'id'=> (string)$this->id,
        'attributes'=>[

            'name'=>$this->name,
            'description'=>$this->description,
            'price'=>$this->price,
            'category_id'=>$this->category_id,
            'image'=> $this->image,
            'package_insert'=> $this->package_insert,
            'concentration' => $this->concentration,
            'category_id' => $this->category_id,
            'need_prescription' => $this->need_prescription
            ]


        ];
    }
}
