<?php

use Carbon\Traits\Rounding;

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
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => ['role:Visitor|Admin']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('roles', 'Roles\RolesController@index')->name('roles.index');
    // datatables route
    Route::get('/get_roles', 'Roles\RolesController@get_roles')->name('get.roles');

    Route::get('cities', 'Cities\CitiesController@index')->name('cities.index');
    // datatables route
    Route::get('/get_cities', 'Cities\CitiesController@get_cities')->name('get.cities');

    Route::group(['middleware' => ['role:Admin']], function () {
        /***********************
             Roles CRUD Operations
         *************************/
        Route::get('roles/create ', 'Roles\RolesController@create')->name('roles.create');
        Route::post('roles', 'Roles\RolesController@store')->name('roles.sotre');
        Route::get('roles/{role}/edit', 'Roles\RolesController@edit')->name('roles.edit');
        Route::put('roles/{role}', 'Roles\RolesController@update')->name('roles.update');
        Route::delete('roles/{role}', 'Roles\RolesController@delete')->name('roles.delete');

        /*************************
             Cities CRUD Operations
         ***************************/
        Route::get('cities/create ', 'Cities\CitiesController@create')->name('cities.create');
        Route::post('cities', 'Cities\CitiesController@store')->name('cities.sotre');
        Route::get('cities/{city}/edit', 'Cities\CitiesController@edit')->name('cities.edit');
        Route::put('cities/{city}', 'Cities\CitiesController@update')->name('cities.update');
        Route::delete('cities/{city}', 'Cities\CitiesController@delete')->name('cities.delete');
    });
});
