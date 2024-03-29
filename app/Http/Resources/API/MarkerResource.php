<?php

namespace App\Http\Resources\API;


use Illuminate\Http\Resources\Json\JsonResource;

class MarkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
            'id'=>$this->id,
            'user' => $this->user->f_name .' '. $this->user->l_name,
            'title' => $this->title,
            'gender' => $this->gender,
            'mental_state' => $this->mental_state,
            'adult' => $this->adult,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'proof' => asset('storage/uploads/markers/proofs/'.$this->proof),
            'status' => $this->status ==  1?  "تمت المساعده":"لم تتم المساعده",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links'=>[
                'help' => url('api/v1/marker/'.$this->id.'/help/'),
                'report' => url('api/v1/marker/'.$this->id.'/report/'),
            ]
          ];
    }
}
