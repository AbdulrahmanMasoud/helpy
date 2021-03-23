<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReportCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($report){
            return [
            'id'=>$report->id,
            'title' => $report->title,
            'proof' => asset('storage/uploads/reports/proofs/'.$report->proof),
            'created_at' => $report->created_at,
            'updated_at' => $report->updated_at,
            'links'=>[
                'report' => url('api/v1/marker/'.$report->marker->id .'/report/'.$report->id),
            ]
            ];
        });
    }
}
