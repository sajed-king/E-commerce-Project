<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
     
            'id' => (string)$this->id,
            'attributes'=>[
    
                'user_id'=>$this->user_id,
                'session_id'=>$this->session_id,
                'status'=>$this->status,
                'total_price'=>$this->total_price,
                'created_at'=> $this->created_at,
                'updated_at'=>$this->updated_at,
                
            ],

            'relationships'=>[
'user'=>[
    'id'=> (string)$this->user->id,
    'name'=> $this->user->name,
],
'address'=>[
    "id" => (string)$this->address->id,
    "street_address"=> $this->address->street_address,
    "city"=> $this->address->city,
    "postal_code"=> $this->address->postal_code,
    "phone_number"=> $this->address->phone_number,
    'created_at'=>  $this->created_at,
    'updated_at'=>$this->updated_at,
    
]




                ]
    
            ];
    }
}
