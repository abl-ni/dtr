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

Route::view('/','welcome');

Auth::routes();

Route::middleware(['auth'])->group(function () {

   
    Route::get('dashboard', 'ProjectController@getQuery'); 
    Route::post('addProject', 'ProjectController@addProject'); 
    Route::post('updateProject/{id}', 'ProjectController@updateProject'); 
    Route::post('deleteProject/{id}', 'ProjectController@deleteProject');
    Route::post('project', 'ProjectController@getProject');
    Route::post('getDev', 'ProjectController@getDev');
    Route::get('project/{id}', 'ProjectController@show');
    
    Route::post('addDev','ProjectDevsController@addDev');
    Route::post('ListDev','ProjectDevsController@getListDev');
    Route::post('removeDev/{id}','ProjectDevsController@removeDev');

    Route::post('addLogs', 'DtrController@addLogs');
    
    Route::get('reports', 'FilterController@getQuery');
    Route::post('getFilter', 'FilterController@getFilter');
    
    Route::put('users/resetPassword/{id}','UserController@resetPassword');
    Route::resource('users','UserController');
    
    
});


