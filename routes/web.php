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
    'namespace' => 'App\Http\Controllers\Auth'
], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@authenticate')->name('authenticate');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::group([
    'middleware' => 'auth',
    'namespace' => 'App\Http\Controllers\CMS'
], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::group([
        'prefix' => 'admin'
    ], function () {
        Route::get('/', 'UserController@index');
        Route::get('/fn_get_data', 'UserController@fnGetData');
        Route::get('/create', 'UserController@create');
        Route::post('/create', 'UserController@store');
        Route::get('/{id}', 'UserController@edit');
        Route::post('/{id}', 'UserController@update');
        Route::get('delete/{id}', 'UserController@delete');
    });

    Route::group([
        'prefix' => 'role'
    ], function () {
        Route::get('/', 'RoleController@index');
        Route::get('/fn_get_data', 'RoleController@fnGetData');
        Route::get('/create', 'RoleController@create');
        Route::post('/create', 'RoleController@store');
        Route::get('/{id}', 'RoleController@edit');
        Route::post('/{id}', 'RoleController@update');
        Route::get('delete/{id}', 'RoleController@delete');
    });

    Route::group([
        'prefix' => 'menu-group'
    ], function () {
        Route::get('/', 'MenuGroupController@index');
        Route::get('/fn_get_data', 'MenuGroupController@fnGetData');
        Route::get('/create', 'MenuGroupController@create');
        Route::post('/create', 'MenuGroupController@store');
        Route::get('/{id}', 'MenuGroupController@edit');
        Route::post('/{id}', 'MenuGroupController@update');
        Route::post('update-status/{id}', 'MenuGroupController@updateStatus');
        Route::get('delete/{id}', 'MenuGroupController@delete');
    });

    Route::group([
        'prefix' => 'menu-item'
    ], function () {
        Route::get('/', 'MenuItemController@index');
        Route::get('/fn_get_data', 'MenuItemController@fnGetData');
        Route::get('/create', 'MenuItemController@create');
        Route::post('/create', 'MenuItemController@store');
        Route::get('/{id}', 'MenuItemController@edit');
        Route::post('/{id}', 'MenuItemController@update');
        Route::get('delete/{id}', 'MenuItemController@delete');
    });
});
