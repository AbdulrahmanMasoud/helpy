<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ResponsTrait;
use App\Traits\UploadImageTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
use ResponsTrait,UploadImageTrait;
   /**
     * This Login For Users 
     * 1- Valedation
     * 2- Check User IS Exist Or Not
     * 3- If User Not Exist Will Return False And Error Message
     * 4- if User Exist Will Generate Token And Return success Message For Him 
     */

     /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      operationId="userLogin",
     *      tags={"User"},
     *      summary="Login In Helpy",
     *      description="You Must Add Valed Email & Password",
     * @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"email","password"},
     *                  
     *                  @OA\Property(
     *                      property="email",
     *                      type="email",
     *                      description="You Must Add Vailed Email"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="password",
     *                      description="You Must Add Vailed Password"
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
     *          response=200,
     *          description="Success Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
*/

    public function login(LoginRequest $request){
     
        // 2- Check User
        $credentials = $request->validated(); // Get evrey thing validated from input
        $token =  Auth::guard('api')->attempt($credentials);

        // 3- if User Not Exist
        if(!$token){ 
            return $this->returnError('كلمه السر غير صحيحه',Response::HTTP_NOT_FOUND);
        }

        // 4- if User Exist
        $user = Auth::guard('api')->user();
        // $user->user_token = $token;
        return response()->json([
            'status'=>true,
            'msg'=>'تم تسجيل الدخول بنجاح',
            'user_token'=>$token,
        ],Response::HTTP_OK);
    }

    /**
     * This Method To Regesteration 
     * 1- Valedation
     * 2- Get Errors If Valedator Has Errors 
     * 3- Check If request Has A File avatar will Move this File In to uploads File
     * 4- Insert Data 
     * 5- Return Success Response  
     */


    /**
     * @OA\Post(
     *      path="/api/v1/register",
     *      operationId="userRegister",
     *      tags={"User"},
     *      summary="ٌRegister In Helpy",
     *      description="ٌYou Must add real data Like Name Email Phone Number And Password",
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
     *                      type="string",
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
     *      )
     * )
*/

    public function register(RegisterRequest $request){

    $avatar = $this->uploadImageAndReturnName($request,'avatar','avatar','app/public/uploads/avatars','defalt.png');

    $user =  User::create($request->except('avatar') + [
            'avatar' => $avatar
        ]);
        $token = JWTAuth::fromUser($user);
        // 5- Return Success Response 
        return response()->json([
            'status'=>true,
            'msg'=>'تم التسجيل بنجاح',
            'user_token'=>$token,
        ],Response::HTTP_CREATED);
    }




    /*
    * This Method To Logout 
    * 1- Logout
    * 2- Return Success Message
    */

    /**
     * @OA\Post(
     *      path="/api/v1/logout",
     *      operationId="userLogout",
     *      tags={"User"},
     *      summary="ٌLogout From Helpy",
     *      description="ٌYou Must Add Token To get access Logout",
     *      security={{"bearer":{}}},
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response( 
     *          response=200,
     *          description="Success Request",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
*/

    public function logout(){

        // 1- Logout
        Auth::logout();

       // 2- Return Success Message
        return $this->returnSuccessMessage('تم تسجيل الخروج',Response::HTTP_OK);
    }

}
