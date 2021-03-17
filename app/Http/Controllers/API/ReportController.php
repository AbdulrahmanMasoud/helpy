<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ReportRequest;
use App\Http\Resources\API\ReportCollection;
use App\Http\Resources\API\ReportResource;
use App\Models\Marker;
use App\Models\Report;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
   
    public function index($marker)
    {
        $reports = Report::where('marker_id', $marker)->with('user','marker')->get();
        // return ReportResource::collection($reports);
        return new ReportCollection($reports);
    }

   
    public function store(ReportRequest $request,$marker)
    {
    
        // Report::firstOrCreate([
        //     // لو لقي دي موجودههيعمل تعديل بالنسبه للباقي لو مش لاقيها موجوده هيعمل واحده جدايده 
        //     'marker_id'=>$marker,
        //     'user_id'=> Auth::id(),
        // ],[
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'proof' => $request->proof
        // ]);
        Report::create(
            $request->validated() + [
            'marker_id'=>$marker,
            'user_id' => Auth::id(),
            
            // [2] Add Proof For This Marker
            'proof' => $request->hasFile('proof') ? $request->file('proof')->store('uploads/proofs','public'): null
            ]);
        return response()->json([
            'status'=>true,
            'msg'=>'Thank You For Your Report',
        ],Response::HTTP_CREATED);
    }

   
    public function show(Marker $marker,Report $report)
    {
        return new ReportResource($report);
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
