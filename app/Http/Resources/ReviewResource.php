<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'id' => $this->id,  
            'rating' => $this->rating,  
            'description' => $this->description,  
            'user_id' => $this->user->id, // example, if you include user  
            'created_at' => $this->created_at,  
        ];
    }
}
