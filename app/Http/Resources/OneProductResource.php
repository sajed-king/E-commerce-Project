<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
class OneProductResource extends JsonResource
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
    
                'name'=>$this->name_en ,
                'description'=>$this->description_en,
                'price'=>$this->price,
                'image'=> $this->image,
                'rating'=> $this->rating,
                'package_insert'=> $this->package_insert,
                'created_at'=> $this->created_at,
                'updated_at'=>$this->updated_at
            ],
    'relationsships'=>[
  'reviews' => [ReviewResource::collection($this->whenLoaded('reviews'))],    
  ]

            ];    }
}
