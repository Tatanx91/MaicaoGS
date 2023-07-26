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

Route::middleware('auth:jwt')->get('/', function (Request $request) {
    return $request->user();
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'AuthXMaicaX'

], function ($router) {

    Route::post('/login',[
	    'uses' => 'AuthController@login',
	    'as' => 'login'
	]);
	
	Route::post('/loginClaro',[
	    'uses' => 'AuthController@loginClaro',
	    'as' => 'loginClaro'
	]);
	
    Route::post('logout', 'AuthController@logout');
    Route::post('logoutClaro', 'AuthController@logoutClaro');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});