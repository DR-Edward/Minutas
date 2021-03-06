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

// ROUTES -> Auth
Route::group([
    'prefix' => 'auth', 
    'namespace' => 'App\Http\Controllers\Auth'
], function () {
    Route::post('login', "LoginController@api_login");
    Route::post('register', "RegisterController@store");
  
    Route::group([
        'middleware' => 'auth:api',
    ], function() {
        Route::post('logout', "LoginController@api_logout");
        Route::patch('user/password', "PasswordController@update");
    });
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'App\Http\Controllers'
], function() {
    // ROUTES -> Users
    Route::apiResource('users', 'UserController');

    // ROUTES -> Amigos
    Route::apiResource('amigos', 'AmigoController');

    // ROUTES -> Minutas
    Route::apiResource('minutas', 'MinutaController');
});