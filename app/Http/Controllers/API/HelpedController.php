<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\HelpedRequest;
use App\Models\Helped;
use App\Models\Marker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HelpedController extends Controller
{
    /**
     * This Store Method To Make marker Done 
     * [1] Add New Row In Database Has user_id and Marker_id and you can add Description and Proof
     * [2] Make This Marker Helped 
     * [3] Return Success Message 
     */
    public function store(HelpedRequest $request, $marker){
        // [1] Add New Row
        Helped::firstOrCreate([
            'user_id'=> Auth::id(),
            'marker_id'=>$marker,
            'description' => $request->description,
            'proof' => $request->proof,
        ]);
        // [2] Make This Marker Helped
        Marker::where('id',$marker)->update(['status'=>1]);
        // [3] Return Success Message
        return response()->json([
            'status'=>true,
            'msg'=>'Thank You For Your Help',
        ],Response::HTTP_CREATED);
    }
}
