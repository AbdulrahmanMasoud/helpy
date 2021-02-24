<?php

use App\Http\Controllers\API\AuthController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:api'],'prefix' => 'v1'], function () {
    Route::post('register',[AuthController::class,'register'])->withoutMiddleware('auth:api');
    Route::post('login',[AuthController::class,'login'])->name('login')->withoutMiddleware('auth:api');
    Route::post('logout',[AuthController::class,'logout']);

    Route::prefix('profile')->group(function () {
        Route::get('/{id}');
    });
    
});
