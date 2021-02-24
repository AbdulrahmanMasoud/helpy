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

    /*
    * This Method To Regesteration 
    */
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'f_name'=> 'required',
            'l_name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'phone'=> 'required|size:11',
            'avatar' => 'file|mimes:jpg,png,jpge,jpeg',
            'password'=> 'required',
        ],$messages =[
            'email' => 'Pleas Add Valid Email address',
            'name.required' => 'We need to know your Name',
            'email.required' => 'We need to know your email address!',
            'password.required' => 'We need to know your Password',
        ]);
        $errors = $validator->errors();
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'errors'=>$errors
            ],Response::HTTP_BAD_REQUEST);
        }
        
        if ($request->hasFile('avatar')) {$path = $request->file('avatar')->store('uploads/avatars','public');}

        User::insert([
            'f_name'=>$request->f_name,
            'l_name'=>$request->l_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
             'avatar'=> $request->hasFile('avatar') ? $request->file('avatar')->hashName(): "https://static.thenounproject.com/png/363640-200.png",
            'password'=>bcrypt($request->password)
        ]);
        return response()->json([
            'status'=>true,
            'msg'=>'You Are Register',
        ],Response::HTTP_CREATED);
    }




    /*
    * This Method To Logout 
    */
    public function logout(){
  
        Auth::logout();
        return response()->json([
            'status'=>true,
            'msg'=>'You Are Logout',
        ]);
        
    }

}
