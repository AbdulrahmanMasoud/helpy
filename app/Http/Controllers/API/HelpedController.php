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
    public function store(HelpedRequest $request, $marker){
        Helped::firstOrCreate([
            'user_id'=> Auth::id(),
            'marker_id'=>$marker,
            'description' => $request->description,
            'proof' => $request->proof,
        ]);
        Marker::where('id',$marker)->update([
            'status'=>1
        ]);
        return response()->json([
            'status'=>true,
            'msg'=>'Thank You For Your Help',
        ],Response::HTTP_CREATED);
    }
}
