<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes(['register' => false]);

Route::group( ['middleware' => 'auth' ], function()
{
    
    
    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::get('/projects/{id}', 'ProjectController@show');
    Route::post('/projects/add', 'ProjectController@add');
    Route::post('/projects/update', 'ProjectController@update');
    Route::get('/projects', 'ProjectController@all');
    
    Route::post('/entries/start', 'EntryController@start');
    Route::post('/entries/stop', 'EntryController@stop');
    Route::post('/entries/delete', 'EntryController@delete');
});


Route::fallback(function(){
    return redirect('login');
});