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

// Route::get('/ex', function () {
//     return view('view_visitors_export');
// });

Route::get('ss', 'NewsController@getRelatedNews');

// Route::get('get_staff','StaffController@getStaffMembers');

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => 'is-active'], function () {
        Route::get('get-city-list', 'CitiesController@getCityList');
        Route::get('get-author-list', 'StaffController@returnStaff');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::post('upload/files', 'NewsController@storeFiles')
            ->name('news.storeFiles');
        // Route::post('upload/files', 'StaffController@storeFiles')
        //     ->name('staff.storeImage');
        // Route::post('upload/files', 'VisitorsController@storeFiles')
        //     ->name('visitors.storeImage');

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
        Route::get('/staff/{staff}/toggle', 'StaffController@toggleBan')
            ->name('visitors.toggleStatus');
        /*************************
        Visitors CRUD Operations
         ***************************/
        Route::resource(
            'visitors',
            'VisitorsController',
            array('except' => 'show')
        );
        Route::get('/visitors/export', 'VisitorsController@export')->name('visitors.export');
        Route::get('/visitors/{visitor}/toggle', 'VisitorsController@toggleBan')
            ->name('visitors.toggleStatus');

        /*************************
        News CRUD Operations
         ***************************/
        Route::resource(
            'news',
            'NewsController'
        );
        Route::get('/news/{news}/toggle', 'NewsController@togglePublish')
            ->name('news.toggleStatus');
    });
});
