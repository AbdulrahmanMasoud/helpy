<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\HelpedRequest;
use App\Models\Helped;
use App\Models\Marker;
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

    
    /**
     * @OA\Post(
     *      path="/api/v1/marker/{marker}/help",
     *      operationId="Help Marker",
     *      tags={"Helped"},
     *      summary="Help Marker",
     *      description="ٌJust To Help This Marker By Id",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="marker",
     *          description="Must Add Marker Id To Can Help It ",
     *          required=true,
     *          in="path",
     *          example="2",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="proof",
     *                      type="file",
     *                      description="Proof Is Optionel"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Description  Is Optionel"
     *                  ),
     *                  
     *             )
     *         )
     *      ),
     * 
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response( 
     *          response=201,
     *          description="Cearated Done",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          )
     *      )
     * )
*/
    public function store(HelpedRequest $request,$marker){
        // [1] Add New Row
        Helped::firstOrCreate([
            // لو لقي دي موجودههيعمل تعديل بالنسبه للباقي لو مش لاقيها موجوده هيعمل واحده جدايده 
            'marker_id'=>$marker,
            'user_id'=> Auth::id(),
        ],[
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
