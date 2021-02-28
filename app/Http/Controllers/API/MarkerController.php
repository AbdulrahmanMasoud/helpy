<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AddMarkerRequest;
use App\Http\Resources\API\MarkerResource;
use App\Models\Marker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MarkerController extends Controller
{
    /**
     * This Method To Get All Markers
     * [1] Just Get All Marker From Resource And Make a Pagination Like 10 per Page
     */
    public function index()
    {
        // [1] Just Get All Marker
        $marker = Marker::simplePaginate(10);
        return MarkerResource::collection($marker);
    }

   /**
    * This Method To Add New Marker
    * [1] Create New Marker
    * [2] Add Proof For This Marker
    * [3] Return Success Response 
    */
    public function store(AddMarkerRequest $request)
    {
        //[1] Create New Marker
        Marker::create(
            $request->except('user_id') + [
            'user_id' => Auth::id(),
            // [2] Add Proof For This Marker
            'proof' => $request->hasFile('proof') ? $request->file('proof')->store('uploads/proofs','public'): null
            ]);

        // [3] Return Success Response 
        return response()->json([
            'status'=>true,
            'msg'=>'تم اضافة الحاله بنجاح',
        ],Response::HTTP_CREATED);
    }

    /**
     * This Method To Show One Marker By Id
     * [1] Just Get One Marker From Resource By Id
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
    public function update(AddMarkerRequest $request, Marker $marker)
    {
    // [1] Check If This User Is a Owner Or Not
      if ($request->user()->id !== $marker->user_id) {
        return response()->json([
            'status'=>false,
            'msg' => 'You can only edit your own marker.'],
             403);
      }
      // [2] Update All Data
      $request->proof=$request->hasFile('proof') ? $request->file('proof')->store('uploads/proofs','public'): null;
        $marker->update($request->all());
        return response()->json([
            'status'=>true,
            'msg' => 'تم التعديل بنجاح'],
             200);
    }

    /**
     * This Method To Delete The Marker 
     * [1] Check If This User Is a Owner Or Not
     * [2] Just Delete Marker Depend The Marker
     */
    public function destroy(Marker $marker)
    {
        //[1] Check If This User Is a Owner Or Not
        if (Auth::id() !== $marker->user_id) {
            return response()->json([
                'status'=>false,
                'msg' => 'You can only Delete your own marker.'],
                 403);
          }
        // [2] Just Delete Marker Depend The Marker
        $marker->delete();
        return response()->json([
            'status'=>true,
            'msg'=>'تم حذف الحالة'
        ]);
    }
}
