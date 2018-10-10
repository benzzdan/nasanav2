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

Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
Route::post('/logout', 'AuthController@logout');


Route::group(['middleware' => 'jwt.auth'], function(){

    Route::get('auth/user', 'AuthController@user');
    //Board Routes
    Route::get('/boards', 'BoardController@index');
    Route::post('/boards', 'BoardController@store');
    Route::get('/boards/{board}', 'BoardController@show');
    Route::put('/boards/{board}', 'BoardController@update');
    Route::delete('/boards/{board}', 'BoardController@destroy');
    //List routes
    Route::get('/boards/{board}/list', 'ListController@index');
    Route::post('/boards/{board}/list', 'ListController@store');
    Route::get('/boards/{board}/list/{list}', 'ListController@show');
    Route::put('/boards/{board}/list/{list}', 'ListController@update');
    Route::delete('/boards/{board}/list/{list}', 'ListController@destroy');
    //Card routes
    Route::get('/boards/{board}/list/{list}/card', 'CardController@index');
    Route::post('/boards/{board}/list/{list}/card', 'CardController@store');
    Route::get('card/{card}', 'CardController@show');
    Route::put('card/{card}', 'CardController@update');
    Route::delete('card/{card}', 'CardController@destroy');
});


Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::get('auth/refresh', 'AuthController@refresh');
  });
