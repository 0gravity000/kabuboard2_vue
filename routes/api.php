<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/apitest', 'App\Http\Controllers\StockController@apitest'); //experiment code
Route::get('/stock/import', 'App\Http\Controllers\StockController@import'); //
Route::get('/stock/index', 'App\Http\Controllers\StockController@index'); //
