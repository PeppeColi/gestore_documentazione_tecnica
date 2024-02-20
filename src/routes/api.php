<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])
     ->group(function(){
         Route::get('/user', function (Request $request) {
             return $request->user();
         });

         // @todo make routes strategy consistent (the mess is actually intentional)
         Route::post('/v1/client/create', 'Api\ClientController@create')->name('api_create_client');
         Route::post('/v1/client/edit', 'Api\ClientController@edit')->name('api_edit_client');

         // Strictly REST
         Route::delete('/v1/client/{id}', 'Api\ClientController@delete')->name('api_delete_client');

         // @todo no version prefix
         Route::put('/project', 'Api\ProjectController@create')->name('api_create_project');

         // REST-like ('create' should be a PUT) and single action ctrl
         Route::post('/document', 'Api\Document\CreateDocumentController')->name('api_create_document');

         // REST and single action ctrl
         Route::post('/v1/document/{id}/validate', 'Api\Document\ValidateDocumentController')->name('api_validate_document');
     });
