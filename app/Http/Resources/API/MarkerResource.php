<?php

namespace App\Http\Resources\API;

use App\Models\User;
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
        $user = User::where('id',$this->user_id)->get()->first();
        $name = $user->f_name . ' '.$user->l_name;
        return [
            'id'=>$this->id,
            'user' => $name,
            'title' => $this->title,
            'gender' => $this->gender,
            'mental_state' => $this->mental_state,
            'adult' => $this->adult,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'proof' => $this->proof,
            'status' => $this->status ==  1?  "تمت المساعده":"لم تتم المساعده",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links'=>[
                'help' => url('api/v1/marker/'.$this->id.'/help/')
            ]
          ];
    }
}
