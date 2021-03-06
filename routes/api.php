<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('brands','BrandController');
Route::apiResource('categories','CategoryController');
Route::apiResource('descriptions','DescriptionController');
Route::apiResource('locations','LocationController');
Route::apiResource('manufactures','ManufactureController');
Route::apiResource('products','ProductController');
Route::apiResource('transfers','TransferController');