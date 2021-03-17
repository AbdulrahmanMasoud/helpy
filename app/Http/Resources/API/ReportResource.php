<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'marker' => $this->marker->title,
            'title' => $this->title,
            'description' => $this->description,
            'proof' => $this->proof,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
          ];
    }
}
