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
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', function(){
        return redirect('/dashboard');
    });

    $this->get('logout', function(){
        Auth::logout();

        Session::flush();

        return redirect('/');
    })->name('logout');

    Route::get('dashboard', 'ProjectController@getQuery'); 
    Route::post('addProject', 'ProjectController@addProject'); 
    Route::post('updateProject', 'ProjectController@updateProject'); 
    Route::post('deleteProject', 'ProjectController@deleteProject');
    Route::post('project', 'ProjectController@getProject');
    Route::post('getDev', 'ProjectController@getDev');
    Route::get('project/{id}', 'ProjectController@show');
    Route::get('projectList', 'ProjectController@projectList');
    
    Route::post('addDev','ProjectDevsController@addDev');
    Route::post('ListDev','ProjectDevsController@getListDev');
    Route::post('removeDev','ProjectDevsController@removeDev');
    Route::post('project/removeDev/{id}','ProjectDevsController@removeDev');

    Route::post('addLogs', 'DtrController@addLogs');
    
    Route::get('reports/{option?}', 'FilterController@getQuery');
    Route::post('getFilter', 'FilterController@getFilter');
    Route::get('reportList', 'FilterController@reportList');
    
    Route::put('users/reset/{option?}','UserController@resetPassword');
    Route::get('profile','UserController@profile');
    Route::resource('users','UserController');
    Route::get('userList','UserController@userList');
     
});