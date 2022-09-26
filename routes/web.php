<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('landing');

Route::group([
    'middleware' => 'guest',
    'namespace' => 'App\Http\Controllers\Auth'
], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@authenticate')->name('authenticate');
});

Route::group([
    'middleware' => 'auth',
    'namespace' => 'App\Http\Controllers'
], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group([
        'prefix' => 'admin'
    ], function () {
        Route::get('/', 'UserController@index');
        Route::get('/fn_get_data', 'UserController@fnGetData');
        Route::get('/create', 'UserController@create');
        Route::post('/create', 'UserController@store');
        Route::get('/{id}', 'UserController@edit');
        Route::post('/{id}', 'UserController@update');
        Route::delete('/{id}', 'UserController@destroy');
    });
});
