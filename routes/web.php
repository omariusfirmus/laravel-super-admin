<?php

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
// test
Route::get('super-admin/login', function () { return view('super-admin.login')->with(['errors_a'=>[]]); })->name('login');
Route::post('/super-admin/authenticate', "superAdmin\pagesController@postLogin");
Route::prefix('super-admin')->middleware(['auth'])->group(function(){
    Route::get('/', function () { return view('super-admin.dashboard')->with(['type'=>'main']); });
    Route::get('page/{type}','superAdmin\pagesController@managePages');


    Route::get('database/view','superAdmin\toolsController@databaseView');
    Route::get('database/add','superAdmin\toolsController@databaseAdd');
    Route::post('database/store','superAdmin\toolsController@databaseStore');
    Route::get('database/delete/{name}','superAdmin\toolsController@databaseDelete');
    Route::get('database/table/{name}','superAdmin\toolsController@databaseEdit');
    Route::post('database/update','superAdmin\toolsController@databaseUpdate');


    Route::get('crud/add/{table_name}','superAdmin\crudController@addCrud');
    Route::post('crud/store/{table_name}','superAdmin\crudController@storeCrud');
    Route::get('crud/edit/{table_name}','superAdmin\crudController@editCrud');
    Route::post('crud/update/{table_name}','superAdmin\crudController@updateCrud');
//    TODO: Delete Crud
    Route::get('crud/delete/{table_name}','superAdmin\crudController@deleteCrud');


    Route::get('section/view/{table_name}','superAdmin\sectionsController@viewSection');
    Route::get('section/add/{table_name}','superAdmin\sectionsController@addSections');
    Route::post('section/store/{table_name}','superAdmin\sectionsController@storeSections');
    Route::get('section/edit/{table_name}/{id}','superAdmin\sectionsController@editSections');
    Route::post('section/update/{table_name}/{id}','superAdmin\sectionsController@updateSections');
    Route::get('section/delete/{table_name}/{id}','superAdmin\sectionsController@deleteSections');

    //Done: Add slug
    Route::post('settings/save','superAdmin\pagesController@saveSettings');
    Route::post('settings/add','superAdmin\pagesController@addSettings');

    //TODO: profile
        Route::get('page/profile','superAdmin\pagesController@editProfile');
        Route::post('updateProfile','superAdmin\pagesController@updateProfile');
        Route::post('change-password','superAdmin\pagesController@changePassword');
    //TODO: sidebar active
    //TODO: notifications
    //TODO: logout
    Route::get('logout','superAdmin\pagesController@logout');
    //TODO: footer
    //TODO: Add Non-Edited Field
    //TODO: API

});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
