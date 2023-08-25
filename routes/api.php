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

Route::group([
    'middleware' => 'app',
    'namespace' => 'App\Http\Controllers\API\Auth'
], function () {
    Route::post('/login', 'AuthController@login');
});

Route::group([
    'middleware' => 'auth.frontend',
    'namespace' => 'App\Http\Controllers\API'
], function () {
    Route::group([
        'namespace' => 'Auth'
    ], function () {
        Route::get('profile', 'AuthController@profile');
    });
});
