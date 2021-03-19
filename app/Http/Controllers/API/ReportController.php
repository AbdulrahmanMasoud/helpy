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
     /**
     * This Method To Get All Reports About Marker
     * [1] Just Get All Reports From Resource
     */
   /**
     * @OA\Get(
     *      path="/api/v1/marker/{marker}/report",
     *      operationId="getReports",
     *      tags={"Report"},
     *      summary="Get All Marker Reports",
     *      description="Returns All Reports About Marker",
     *      security={
     *         {"bearer": {}}
     *      },
     *  @OA\Parameter(
     *          name="marker",
     *          description="Must Add Marker Id To Can See All Reports About This Marker",
     *          required=true,
     *          in="path",
     *          example="2",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function index($marker)
    {
        $reports = Report::where('marker_id', $marker)->with('user','marker')->get();
        // return ReportResource::collection($reports);
        return new ReportCollection($reports);
    }

   
    /**
    * This Method To Add New Report
    * [1] Create New Report
    * [2] Add Proof For This MarkReporter
    * [3] Return Success Response 
    */
     /**
     * @OA\Post(
     *      path="/api/v1/marker/{marker}/report",
     *      operationId="addReport",
     *      tags={"Report"},
     *      summary="Add Report on Marker",
     *      description="ٌJuet To Add Report To Marker",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="marker",
     *          description="Must Add Marker Id To Can Add Report On It ",
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
     *                      property="title",
     *                      type="string",
     *                      description="Just Add Report Title"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Just Add Description  about Your Report"
     *                  ),
     *                  @OA\Property(
     *                      property="proof",
     *                      type="file",
     *                      description="Proof Is Optionel"
     *                  ),
     *                  
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


    /**
     * This Method To Show One Report By Id
     * [1] Just Get One Report From Resource By Id
     */
   /**
     * @OA\Get(
     *      path="/api/v1/marker/{marker}/report/{report}",
     *      operationId="getReport",
     *      tags={"Report"},
     *      summary="Get One Report",
     *      description="Return One Report",
     *      security={
     *         {"bearer": {}}
     *      },
     *  @OA\Parameter(
     *          name="marker",
     *          description="Must Add Marker Id To Can See All Reports About This Marker",
     *          required=true,
     *          in="path",
     *          example="10",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * *  @OA\Parameter(
     *          name="report",
     *          description="Must Add Report Id To Can See This Report",
     *          required=true,
     *          in="path",
     *          example="1",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show(Marker $marker,Report $report)
    {
        return new ReportResource($report);
    }


    /**
     * This Method To Update The Report But Owner only Can Update It
     * [1] Check If This User Is a Owner Or Not If Now Will See The Error Message
     * [2] Update All Data
     */
   /**
     * @OA\Post(
     *      path="/api/v1/marker/{marker}/report/{report}",
     *      operationId="Update Report",
     *      tags={"Report"},
     *      summary="ٌJust Update Report",
     *      description="ٌJust Update Report By Id",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="marker",
     *          description="Must Add Marker Id To Update now wiche Report And Must You are Owner",
     *          required=true,
     *          in="path",
     *          example="2",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="report",
     *          description="Must Add report Id To Update It And Must You are Owner",
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
     *                  required={"_method","title","description"},
     *                  @OA\Property(
     *                      property="_method",
     *                      type="string",
     *                      example="put",
     *                      description="This Method Must Be (put)"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Just Add Title About This Report"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Description  Is Optionel"
     *                  ),
     *                  @OA\Property(
     *                      property="proof",
     *                      type="file",
     *                      description="Proof Is Optionel"
     *                  ),
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
    public function update(ReportRequest $request,$marker,Report $report)
    {
        // [1] Check If This User Is a Owner Or Not
      if (auth()->id() !== $report->user_id) {
        return response()->json([
            'status'=>false,
            'msg' => 'You can only edit your own marker.'],
             403);
      }
      $request->proof=$request->hasFile('proof') ? $request->file('proof')->store('uploads/proofs','public'): null;
      $report->update($request->validated());
      return response()->json([
        'status'=>true,
        'msg' => 'تم التعديل بنجاح'],
         200);
    }


    /**
     * This Method To Delete The Report 
     * [1] Check If This User Is a Owner Or Not
     * [2] Just Delete Report Depend The Marker And Owner
     */

    /**
     * @OA\Delete(
     *      path="/api/v1/marker/{marker}/report/{report}",
     *      operationId="deleteReport",
     *      tags={"Report"},
     *      summary="Delete Report",
     *      description="Just You Can Delete You Owne Report",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="marker",
     *          description="Marker Id",
     *          required=true,
     *          in="path",
     *          example="2",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="report",
     *          description="Report Id",
     *          required=true,
     *          in="path",
     *          example="2",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function destroy($marker,Report $report)
    {
        //[1] Check If This User Is a Owner Or Not
        if (Auth::id() !== $report->user_id) {
            return response()->json([
                'status'=>false,
                'msg' => 'You can only Delete your own report.'],
                 403);
          }
        // [2] Just Delete Report Depend The Report And User Auth
        $report->delete();
        return response()->json([
            'status'=>true,
            'msg'=>'تم حذف '
        ]);
    }
}
