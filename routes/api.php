<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([ 'user' => 'API\UserController' ]);

Route::group([
    'namespace' => 'API\Contacts',
], function () {
    Route::apiResources([ 'client' => 'ClientController' ]);
});

Route::group([
    'prefix' => 'milestones',
    'namespace' => 'API\Milestones',
    'as' => 'milestones.'
], function () {
    Route::apiResources([ 'status' => 'StatusController' ]);
});

Route::group([
    'prefix' => 'tasks',
    'namespace' => 'API\Tasks',
    'as' => 'tasks.'
], function () {
    Route::apiResources([ 'status' => 'StatusController' ]);
});

Route::group([
    'prefix' => 'projects',
    'namespace' => 'API\Projects',
    'as' => 'projects.'
], function () {
    Route::apiResources([ 'status' => 'StatusController' ]);
});

Route::get('profile', 'API\UserController@profile');
Route::get('findUser', 'API\UserController@search');
Route::put('profile', 'API\UserController@updateProfile');

