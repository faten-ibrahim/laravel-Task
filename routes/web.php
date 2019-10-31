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

Route::get('ss', 'FoldersController@getFolders');

// Route::get('get_staff','StaffController@getStaffMembers');
Route::get('vs/{event}', 'EventsController@gett');
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => 'is-active'], function () {
        Route::get('get-city-list', 'CitiesController@getCityList');
        Route::get('get-author-list', 'StaffController@returnStaff');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::post('upload/files', 'FilesController@storeFiles')
            ->name('files.storeFiles');
        Route::get('get-news-list', 'NewsController@getRelatedNews')->name('get-news-list');
        Route::post('remove/file', 'FilesController@removeFiles')->name('files.removeFile');
        Route::get('getFiles', 'FilesController@getFiles')->name('files.getFiles');
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

        Route::get('get-visitors-list', 'VisitorsController@getVisitorsList')->name('get-visitors-list');

        /*************************
        News CRUD Operations
         ***************************/
        Route::resource(
            'news',
            'NewsController'
        );
        Route::get('/news/{news}/toggle', 'NewsController@togglePublish')
            ->name('news.toggleStatus');

        Route::resource(
            'events',
            'EventsController'
        );

        Route::get('get_events', 'EventsController@getEvents');


        Route::resource(
            'folders',
            'FoldersController'
        );


        Route::resource(
            'files',
            'MediaController'
        );

        Route::get('/folders/image/create/{folder?}', function ($folder) {
            return view('folders.media.images.create', compact('folder'));
        })->name('folders.media.images.create');

        Route::get('/folders/file/create/{folder?}', function ($folder) {
            return view('folders.media.files.create', compact('folder'));
        })->name('folders.media.files.create');

        Route::get('/folders/video/create/{folder?}', function ($folder) {
            return view('folders.media.videos.create', compact('folder'));
        })->name('folders.media.videos.create');

        Route::get('/folders/{folderId}/media/edit/{file}', 'MediaController@edit')->name('files.edit');
    });
});
