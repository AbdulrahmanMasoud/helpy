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
    
    public function index()
    {
        $marker = Marker::simplePaginate(10);
        return MarkerResource::collection($marker);
    }

   
    public function store(AddMarkerRequest $request)
    {
        Marker::create(
            $request->except('user_id') + [
            'user_id' => Auth::id()
            ]);

        // 5- Return Success Response 
        return response()->json([
            'status'=>true,
            'msg'=>'تم اضافة الحاله بنجاح',
        ],Response::HTTP_CREATED);
    }

    
    public function show(Marker $marker)
    {
        return new MarkerResource($marker);
        
    }

    
    public function update(AddMarkerRequest $request, Marker $marker)
    {
        // check if currently authenticated user is the owner of the marker
      if ($request->user()->id !== $marker->user_id) {
        return response()->json([
            'status'=>false,
            'msg' => 'You can only edit your own marker.'],
             403);
      }

        $marker->update($request->all());
        return response()->json([
            'status'=>true,
            'msg' => 'تم التعديل بنجاح'],
             200);
    }

    
    public function destroy(Marker $marker)
    {
        $marker->delete();
        return response()->json([
            'status'=>true,
            'msg'=>'تم حذف الحالة'
        ]);
    }

    // private function uploadImage(Request $request)
    // {
    //     return $request->hasFile('image')
    //         ? $request->image->store('public')
    //         : null;
    // }
}
