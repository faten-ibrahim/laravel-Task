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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ex', function () {
    return view('view_visitors_export');
});

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => 'is-active'], function () {
        Route::get('get-city-list', 'CitiesController@getCityList');
        Route::get('/home', 'HomeController@index')->name('home');

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
        Route::get('/staff/{staff}/ban', 'StaffController@ban')
            ->name('staff.ban');
        Route::get('/staff/{staff}/unban', 'StaffController@unban')
            ->name('staff.unban');

        /*************************
        Visitors CRUD Operations
         ***************************/
        Route::resource(
            'visitors',
            'VisitorsController',
            array('except' => 'show')
        );
        Route::get('get_visitors', 'VisitorsController@get_visitors');

        Route::get('/visitors/{visitor}/ban', 'VisitorsController@ban')
            ->name('visitors.ban');
        Route::get('/visitors/{visitor}/unban', 'VisitorsController@unban')
            ->name('visitors.unban');

        Route::get('/visitors/export', 'VisitorsController@export')->name('visitors.export');
    });
});
