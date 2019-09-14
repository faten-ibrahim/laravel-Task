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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('roles', 'Roles\RolesController@index')->name('roles.index');
// datatables route
Route::get('/get_roles', 'Roles\RolesController@get_roles')->name('get.roles');

Route::get('roles/create ', 'Roles\RolesController@create')->name('roles.create');
Route::post('roles', 'Roles\RolesController@store')->name('roles.sotre');
Route::get('roles/{role}/edit', 'Roles\RolesController@edit')->name('roles.edit');
Route::put('roles/{role}', 'Roles\RolesController@update')->name('roles.update');
Route::delete('roles/{role}', 'Roles\RolesController@delete')->name('roles.delete');
