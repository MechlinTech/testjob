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



Route::post('login', ['uses' => 'App\Http\Controllers\LoginController@login', 'as' => 'login']);
Route::get('user', 'App\Http\Controllers\LoginController@details');

Route::group(['middleware' => 'auth:api'],function(){    
    Route::post('usermessage', 'App\Http\Controllers\SupportController@usermessage');
    Route::post('supportreply', 'App\Http\Controllers\SupportController@supportreply');
    Route::get('allSupport', 'App\Http\Controllers\SupportController@allSupport');        
    Route::get('searchSupportByName', 'App\Http\Controllers\SupportController@searchSupportByName');
    Route::get('searchSupportByStatus', 'App\Http\Controllers\SupportController@searchSupportByStatus');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});