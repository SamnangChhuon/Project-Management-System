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

Route::group([
    'namespace' => 'API\Users',
    'as' => 'users.'
], function () {
    Route::get('/users/profile', 'UserController@profile');
    Route::get('/users/findUser', 'UserController@search');
    Route::put('/users/profile', 'UserController@updateProfile');

    Route::get('/users/manager', 'UserController@getUserManager');

    Route::apiResources([ '/users/roles' => 'RoleController' ]);
    Route::apiResources([ '/users' => 'UserController' ]);
});

Route::group([
    'namespace' => 'API\Contacts',
], function () {
    Route::get('/clients/getClients', 'ClientController@getClients');

    Route::apiResources([ 'clients' => 'ClientController' ]);
    Route::apiResources([ 'contacts' => 'ContactController' ]);
});

Route::group([
    'namespace' => 'API\Milestones',
    'as' => 'milestones.'
], function () {
    Route::get('/milestones/getMilestoneStatus', 'StatusController@getStatus')->name('getMilestoneStatus');

    Route::apiResources([ '/milestones-costs' => 'CostController' ]);
    Route::apiResources([ '/milestones-hours' => 'HourController' ]);
    Route::apiResources([ '/milestones-statuses' => 'StatusController' ]);
    Route::apiResources([ '/milestones' => 'MilestoneController' ]);
});

Route::group([
    'namespace' => 'API\Tasks',
    'as' => 'tasks.'
], function () {
    Route::apiResources([ '/tasks/statuses' => 'StatusController' ]);
    Route::apiResources([ '/tasks' => 'TaskController' ]);
});

Route::group([
    'namespace' => 'API\Projects',
    'as' => 'projects.'
], function () {
    Route::get('/projects/getStatus', 'StatusController@getStatus');

    Route::apiResources([ '/projects/statuses' => 'StatusController' ]);
    Route::apiResources([ '/projects' => 'ProjectController' ]);
});



