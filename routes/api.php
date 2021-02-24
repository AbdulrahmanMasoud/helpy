<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * This Is Rouets For All Api 
 * [auth:api] This is middleware For Authntcation  & Authorathation
 * [v1] This is vertion for API
 * [Route register] This For Registratoin
 * [Route login] This For login
 * [Route logout] This For logout
 * 
 * [profile] This Prefix For Profile Api
 * [/] This to get all date about User
 * [profile/update] This to update all date for User
 */

Route::group(['middleware' => ['auth:api'],'prefix' => 'v1'], function () {
    Route::post('register',[AuthController::class,'register'])->name('register')->withoutMiddleware('auth:api');
    Route::post('login',[AuthController::class,'login'])->name('login')->withoutMiddleware('auth:api');
    Route::post('logout',[AuthController::class,'logout'])->name('logout');

    Route::prefix('profile')->group(function () {
        Route::get('/',[ProfileController::class,'index']);
        Route::post('update',[ProfileController::class,'updateProfile']);

    });

    
});
