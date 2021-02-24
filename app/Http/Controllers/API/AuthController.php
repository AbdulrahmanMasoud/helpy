<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{

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

    public function login(Request $request){
        // 1- Valedation
        $validator = Validator::make($request->all(),[
            'email'=> 'required|email',
            'password'=> 'required',
        ],$messages =[
            'email' => 'Pleas Add Valid Email address',
            'email.required' => 'We need to know your email address!',
            'password.required' => 'We need to know your Password',
        ]);
        $errors = $validator->errors();
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'msg'=>'Error',
                'errors'=>$errors
            ],Response::HTTP_BAD_REQUEST);
        }

        // 2- Check User
        $credentials = $request->only('email', 'password');
        $token =  Auth::guard('api')->attempt($credentials);

        // 3- if User Not Exist
        if(!$token){ 
            return response()->json([
            'status'=>false,
            'msg'=>'This User Not Exist',
            ],Response::HTTP_NOT_FOUND);
        }

        // 4- if User Exist
        $user = Auth::guard('api')->user();
        $user->user_token = $token;
        return response()->json([
            'status'=>true,
            'msg'=>'Login User Done ',
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
     *          response=200,
     *          description="Success Request"
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Cearated Done",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
*/

    public function register(Request $request){
        // 1- Valedation
        $validator = Validator::make($request->all(),[
            'f_name'=> 'required',
            'l_name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'phone'=> 'required|size:11',
            'avatar' => 'nullable|file|mimes:jpg,png,jpge,jpeg',
            'password'=> 'required',
        ],$messages =[
            'email' => 'Pleas Add Valid Email address',
            'name.required' => 'We need to know your Name',
            'email.required' => 'We need to know your email address!',
            'password.required' => 'We need to know your Password',
        ]);
        // 2- Get Errors
        $errors = $validator->errors();
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'errors'=>$errors
            ],Response::HTTP_BAD_REQUEST);
        }
        // 3- Check If request Has A File
        if ($request->hasFile('avatar')) {$path = $request->file('avatar')->store('uploads/avatars','public');}
        // 4- Insert Data 
        User::insert([
            'f_name'=>$request->f_name,
            'l_name'=>$request->l_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
             'avatar'=> $request->hasFile('avatar') ? $request->file('avatar')->hashName(): "https://static.thenounproject.com/png/363640-200.png",
            'password'=>bcrypt($request->password)
        ]);
        // 5- Return Success Response 
        return response()->json([
            'status'=>true,
            'msg'=>'You Are Register',
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
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
*/

    public function logout(){

        // 1- Logout
        Auth::logout();

       // 2- Return Success Message
        return response()->json([
            'status'=>true,
            'msg'=>'You Are Logout',
        ],Response::HTTP_OK);
        
    }

}
