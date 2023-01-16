<?php

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

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
*/
Auth::routes();
Route::post('/checklogin', ['as' => 'smt.login', 'uses' => 'Auth\LoginController@checkLogin']);
Route::get('/logout', ['as' => 'smt.logout', 'uses' => 'Auth\LoginController@logout']);


/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/', ['as' => 'dashboard.view', 'uses' => 'Dashboard\DashboardController@index']);
Route::get('/getreports', ['uses' => 'Dashboard\DashboardController@getReports']);


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
*/
Route::post('/user/update', ['as' => 'user.update', 'uses' => 'User\UserController@update']);
Route::post('/user/update-password', ['as' => 'user.update', 'uses' => 'User\UserController@updatePassword']);

/*
|--------------------------------------------------------------------------
| Applications Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/applications/new', ['as' => 'applications.new', 'uses' => 'Application\ApplicationController@create']);
// Route::get('/applications/view/{slug}', ['as' => 'applications.new', 'uses' => 'Application\ApplicationController@view']);
Route::post('/applications/store', ['uses' => 'Application\ApplicationController@store']);
Route::post('/applications/update', ['uses' => 'Application\ApplicationController@update']);
Route::post('/applications/delete/{id}', ['uses' => 'Application\ApplicationController@delete']);
Route::get('/changeslug/{id}', 'Application\ApplicationController@changeApplication');

/*
|--------------------------------------------------------------------------
| Exception Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/exceptions', ['as' => 'exception.view', 'uses' => 'Exception\ExceptionController@index']);
Route::get('/getexceptions', ['as' => 'exception.list', 'uses' => 'Exception\ExceptionController@getExceptions']);
Route::get('/viewexceptions/{id}', ['as' => 'exception.list', 'uses' => 'Exception\ExceptionController@view']);

/*
|--------------------------------------------------------------------------
| Settings Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/settings', ['as' => 'settings.view', 'uses' => 'Application\ApplicationController@view']);
