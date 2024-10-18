<?php

use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'products','as'=>'products.'], function(){
    Route::post('', [ProductController::class, 'store']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::get('', [ProductController::class, 'showlist']);
    Route::put('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}',[ProductController::class, 'delete']);
    Route::patch('/restore/{id}',[ProductController::class,'restore']);
});
