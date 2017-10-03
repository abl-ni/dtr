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

Route::group(['middleware' => 'auth'], function () {

   
    Route::get('dashboard', 'ProjectController@getQuery'); 
    Route::post('addProject', 'ProjectController@addProject'); 
    Route::post('updateProject', 'ProjectController@updateProject'); 
    Route::post('deleteProject', 'ProjectController@deleteProject');
    Route::post('project', 'ProjectController@getProject');
    Route::post('getDev', 'ProjectController@getDev');
    
    Route::post('addDev','ProjectDevsController@addDev');
    Route::post('ListDev','ProjectDevsController@getListDev');

    Route::post('Logs', 'DtrController@addLogs');
    
    Route::get('reports', 'FilterController@getQuery');
    
    });

Auth::routes();
