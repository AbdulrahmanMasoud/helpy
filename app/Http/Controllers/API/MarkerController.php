<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AddMarkerRequest;
use App\Http\Resources\API\MarkerResource;
use App\Models\Marker;
use App\Traits\ResponsTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MarkerController extends Controller
{
    use ResponsTrait, UploadImageTrait;
    /**
     * This Method To Get All Markers
     * [1] Just Get All Marker From Resource And Make a Pagination Like 10 per Page
     */
     /**
     * @OA\Get(
     *      path="/api/v1/marker",
     *      operationId="getAllMarker",
     *      tags={"Marker"},
     *      summary="Get All Marker",
     *      description="Returns One Marker",
     *      security={
     *         {"bearer": {}}
     *      },
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
    public function index()
    {
        // [1] Just Get All Marker Not Helped
        //$marker = Marker::where('status',0)->with('user')->simplePaginate(10);
        $marker = Marker::where('status',0)->with('user')->get();
        return MarkerResource::collection($marker);
    }

    /**
     * This Method To Get All Markers Has Helped
     * [1] Just Get All Marker From Resource And Make a Pagination Like 10 per Page
     */
     /**
     * @OA\Get(
     *      path="/api/v1/marker/helped",
     *      operationId="getAllHelpedMarker",
     *      tags={"Marker"},
     *      summary="Get All Helped Marker",
     *      description="Returns All Markers Helped",
     *      security={
     *         {"bearer": {}}
     *      },
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
    public function helped()
    {
        // [1] Just Get All Marker Helped
        //$helpedMarker = Marker::where('status',1)->with('user')->simplePaginate(10);
        $helpedMarker = Marker::where('status',1)->with('user')->get();
         return MarkerResource::collection($helpedMarker);
    }

   /**
    * This Method To Add New Marker
    * [1] Create New Marker
    * [2] Add Proof For This Marker
    * [3] Return Success Response 
    */

    /**
     * @OA\Post(
     *      path="/api/v1/marker",
     *      operationId="Add Marker",
     *      tags={"Marker"},
     *      summary="ٌJust Add Marker",
     *      description="ٌJust Add Marker To find Any Body Can Help",
     *      security={
     *         {"bearer": {}}
     *      },
     * @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"title","gender","mental_state","adult","latitude","longitude"},
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Just Add Title About This Marker"
     *                  ),
     *                  @OA\Property(
     *                      property="gender",
     *                      type="string",
     *                      enum={"-","ذكر", "انثى"}
     *                  ),
     *                  @OA\Property(
     *                      property="mental_state",
     *                      type="string",
     *                      enum={"-","سوي عقليا", "غير سوي عقليا"}
     *                  ),
     *                  @OA\Property(
     *                      property="adult",
     *                      type="string",
     *                      enum={"-","طفل","بالغ","مُسن"}
     *                  ),
     * 
     *                  @OA\Property(
     *                      property="latitude",
     *                      type="decimel",
     *                      description="Must Add Latitude Like: 20.303418"
     *                  ),
     *                  @OA\Property(
     *                      property="longitude",
     *                      type="decimel",
     *                      description="Must Add Longitude Like: 44.392414"
     *                  ),
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
    public function store(AddMarkerRequest $request)
    {
        $proof = $this->uploadImageAndReturnName($request,'proof','markerproof','app/public/uploads/markers/proofs','defalt.png');
        //[1] Create New Marker
        Marker::create(
            $request->except('proof') + [
            'user_id' => Auth::id(),
            'proof' => $proof
            ]);

        // [3] Return Success Response 
        return $this->returnSuccessMessage('تم اضافة الحاله بنجاح',Response::HTTP_CREATED);
    }

    /**
     * This Method To Show One Marker By Id
     * [1] Just Get One Marker From Resource By Id
     */

     /**
     * @OA\Get(
     *      path="/api/v1/marker/{marker}",
     *      operationId="getMarker",
     *      tags={"Marker"},
     *      summary="Get One Marker",
     *      description="Returns One Marker",
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
    public function show(Marker $marker)
    {
        // [1] Just Get One Marker
        return new MarkerResource($marker); 
       
    }

    /**
     * This Method To Update The Marker But Owner only Can Update It
     * [1] Check If This User Is a Owner Or Not If Now Will See The Error Message
     * [2] Update All Data
     */

    
    /**
     * @OA\Post(
     *      path="/api/v1/marker/{marker}",
     *      operationId="Update Marker",
     *      tags={"Marker"},
     *      summary="ٌJust Update Marker",
     *      description="ٌJust Update Marker By Id",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="marker",
     *          description="Must Add Marker Id To Update It And Must You are Owner",
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
     *                  required={"_method","title","gender","mental_state","adult","latitude","longitude"},
     *                  @OA\Property(
     *                      property="_method",
     *                      type="string",
     *                      example="put",
     *                      description="This Method Must Be (put)"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Just Add Title About This Marker"
     *                  ),
     *                  @OA\Property(
     *                      property="gender",
     *                      type="string",
     *                      enum={"-","ذكر", "انثى"}
     *                  ),
     *                  @OA\Property(
     *                      property="mental_state",
     *                      type="string",
     *                      enum={"-","سوي عقليا", "غير سوي عقليا"}
     *                  ),
     *                  @OA\Property(
     *                      property="adult",
     *                      type="string",
     *                      enum={"-","طفل","بالغ","مُسن"}
     *                  ),
     * 
     *                  @OA\Property(
     *                      property="latitude",
     *                      type="decimel",
     *                      description="Must Add Latitude Like: 20.303418"
     *                  ),
     *                  @OA\Property(
     *                      property="longitude",
     *                      type="decimel",
     *                      description="Must Add Longitude Like: 44.392414"
     *                  ),
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
    public function update(AddMarkerRequest $request, Marker $marker)
    {
    // [1] Check If This User Is a Owner Or Not
      if (auth()->id() !== $marker->user_id) {
            return $this->returnError('تستطيع فقط تعديل الحاله الخاصة بك',Response::HTTP_FORBIDDEN);
      }
      // [2] Update All Data
        $proof = $this->uploadImageAndReturnName($request,'proof','markerproof','app/public/uploads/markers/proofs','defalt.png');
      $marker->update($request->except('proof')+['proof'=>$proof]);
    return $this->returnSuccessMessage('تم التعديل بنجاح',Response::HTTP_OK);
    }

    /**
     * This Method To Delete The Marker 
     * [1] Check If This User Is a Owner Or Not
     * [2] Just Delete Marker Depend The Marker
     */

     /**
     * @OA\Delete(
     *      path="/api/v1/marker/{marker}",
     *      operationId="deleteMarker",
     *      tags={"Marker"},
     *      summary="Delete Marker",
     *      description="Just You Can Delete You Owne Marker",
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
     *      @OA\Response(
     *          response=200,
     *          description="Success Request",
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
    public function destroy(Marker $marker)
    {
        //[1] Check If This User Is a Owner Or Not
        if (Auth::id() !== $marker->user_id) {
            return $this->returnError('تستطيع فقط حذف الحاله الخاصة بك',Response::HTTP_FORBIDDEN);
          }
        // [2] Just Delete Marker Depend The Marker
        $marker->delete();
        return $this->returnSuccessMessage('تم حذف الحالة بنجاح',Response::HTTP_OK);
    }

    
}
