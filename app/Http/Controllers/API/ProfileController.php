<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /** This Method To Get All Data About User
     * 1- make new Obj fro carunt User
     * 2- Response data as a json
     */

    /**
     * @OA\Get(
     *      path="/api/v1/profile",
     *      operationId="getProfileData",
     *      tags={"Profile"},
     *      summary="Get Porofile Data",
     *      description="This To Get Full Data About Auth User",
     *       security={
     *         {"bearer": {}}
     *       },         
     *      @OA\Response( response=400, description="Bad Request"),
     *      @OA\Response( 
     *          response=200,
     *          description="Success Request",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          )
     *      ),
     *      @OA\Response( response=401, description="Unauthenticated",),
     *      @OA\Response( response=403, description="Forbidden")
     * )
*/

    public function index()
    {
        // 1- new obj
        $user = Auth::user();
        $user->avatar = public_path('storage/app/public/uploads/avatars').'/'.$user->avatar;
        // 2- Response Data
        return response()->json([
            'status' => true,
            'data' => $user
        ],Response::HTTP_OK);
    }

    /** This Method To Update All Data in User
     * 1- Make new full valedation for all data
     * 2- Cusome Message For Valedation
     * 3- If Valedation Has Errors Will Return It As A Response
     * 4- Check If request Has A File avatar will Move this File In to uploads File
     * 5- Get User data to Select avatar Form It if user Dosen't update avatar will Update the curant avatar
     * 6- Update Data 
     * 7- If Updated Done Will Return Response Has A Success Message
     */


         /**
     * @OA\Post(
     *      path="/api/v1/profile/update",
     *      operationId="Update Profile",
     *      tags={"Profile"},
     *      summary="Update Profile Data ",
     *      description="This To Update Full Data About Auth User",
     *      security={
     *         {"bearer": {}}
     *     },
     * @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"f_name","l_name","email","phone","password"},
     *                  @OA\Property(
     *                      property="f_name",
     *                      type="string",
     *                      description="You must add First Name"
     *                  ),
     *                  @OA\Property(
     *                      property="l_name",
     *                      type="string",
     *                      description="You must add Last Name"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      description="You must add Email"
     *                  ),
     *                  @OA\Property(
     *                      property="phone",
     *                      type="phone",
     *                      description="You must add Phone Number"
     *                  ),
     *                  @OA\Property(
     *                      property="avatar",
     *                      type="file",
     *                      description="Avatar Is Optionel"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="password",
     *                      description="You must add Password"
     *                  ),
     *                  @OA\Property(
     *                      property="gender",
     *                      type="string",
     *                      enum={"-","female", "male"}
     *                  ),
     *                  @OA\Property(
     *                      property="country",
     *                      type="string",
     *                      description="Country Is Optional"
     *                  ),
     *                  @OA\Property(
     *                      property="city",
     *                      type="string",
     *                      description="City Is Optional"
     *                  ),
     *                  @OA\Property(
     *                      property="address",
     *                      type="string",
     *                      description="Address Is Optional"
     *                  ),
     *             )
     *         )
     *      ),
     *      @OA\Response( response=400, description="Bad Request"),
     *      @OA\Response( 
     *          response=200,
     *          description="Success Request",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          )
     *      ),
     *      @OA\Response( response=401, description="Unauthenticated",),
     *      @OA\Response( response=403, description="Forbidden")
     * )
*/

    public function updateProfile(UpdateProfileRequest $request)
    {
        // 4- If Requst Has File
        // if ($request->hasFile('avatar')) {
        //     $path = $request->file('avatar')->store('uploads/avatars','public');
        // }
        // 5- Get User Data
        // $user = User::where('id',Auth::id())->first();

        // auth()->user();

        if($request->hasFile('avatar') ){
            $avatar = $request->avatar;
            $extension=$avatar->extension();
            $name =Auth::id().rand(0,9999999).'.'.$extension;
            $avatar->storeAs('uploads/avatars',$name,'public');
        }else{
            $name = 'defult.png';
        }
       // 6- Update Data
        $updateUser =  auth()->user()->update($request->except('avatar')+[
            'avatar' =>$name
        ]);
       // 7- If Updated Done
        if($updateUser){ 
            return response()->json([
                'status'=>true,
                'msg'=>'Updated Done'
            ],Response::HTTP_CREATED);
        }
  
    }




    public function destroy($id)
    {
        //
    }
}
