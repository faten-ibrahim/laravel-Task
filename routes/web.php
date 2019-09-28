<?php

use Carbon\Traits\Rounding;
use Illuminate\Support\Facades\DB;
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

// DB::listen(function($sql) {

// });

// Route::get('get_roles','Roles\RolesController@get_roles');
// Route::get('get_cities','Cities\CitiesController@get_cities');
// Route::get('get_jobs','JobsController@get_jobs');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Route::get('roles', 'Roles\RolesController@index')->name('roles.index');

    // Route::get('cities', 'Cities\CitiesController@index')->name('cities.index');


    /***********************
        Roles CRUD Operations
     *************************/
    Route::resource(
        'roles',
        'RolesController',
        array('except' => 'show')
    );

    /*************************
        Cities CRUD Operations
     ***************************/
    Route::resource(
        'cities',
        'CitiesController',
        array('except' => 'show')
    );

    /*************************
        Jobs CRUD Operations
     ***************************/
    Route::resource(
        'jobs',
        'JobsController',
        array('except' => 'show')
    );

    /*************************
        Staff Members CRUD Operations
     ***************************/
    Route::resource(
        'staff',
        'StaffController',
        array('except' => 'show')
    );

    Route::get('get_staff', 'StaffController@get_staff_members');
    Route::get('get-city-list','StaffController@getCityList');

    /*************************
        Visitors CRUD Operations
     ***************************/
    Route::resource(
        'visitors',
        'VisitorsController',
        array('except' => 'show')
    );
});
