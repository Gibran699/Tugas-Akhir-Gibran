<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\System\MainController as SystemMainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login',[AuthController::class,'login']);
Route::middleware('auth:api')->group(function(){
    Route::get('list/jenis_data',function()  {
        return config('dataArray.listCalculateDataFunction');
    });
    Route::post('search_data/{jenisData}',[SystemMainController::class,'searchData']);
});
