<?php

declare(strict_types=1);

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

Auth::routes(['register' => false]);

Route::middleware('auth')
     ->group(function() {
         // Default HP
         Route::get('/', function(){
             // @todo avoid closures, and enable route caching
             return redirect(route('home'));
         })->name('default_hp');

         // Dashboard
         Route::get('/home', 'HomeController@index')->name('home');

         // @todo misleading route
         Route::get('/client/{id}', 'ProjectController@index')->name('projects_index');

         // REST route
         Route::get('/project/{id}', 'ProjectController@show')->name('project');

         // User handlers (auth session / CSRF token based), see config/auth.php
         Route::post('/api/v1/user/create', 'Api\UserController@create')->name('api_create_user');
         Route::post('/api/v1/user/edit', 'Api\UserController@edit')->name('api_edit_user');
         Route::post('/api/v1/user/delete', 'Api\UserController@delete')->name('api_delete_user');
     });
