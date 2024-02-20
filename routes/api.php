<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

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