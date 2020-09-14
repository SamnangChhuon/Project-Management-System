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
    Route::get('users/profile', 'UserController@profile');
    Route::get('users/findUser', 'UserController@search');
    Route::put('users/profile', 'UserController@updateProfile');

    Route::get('users/manager', 'UserController@getUserManager');

    Route::apiResources([ 'users' => 'UserController' ]);
    Route::apiResources([ 'users/role' => 'RoleController' ]);
});

Route::group([
    'namespace' => 'API\Contacts',
], function () {
    Route::apiResources([ 'client' => 'ClientController' ]);
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
    Route::get('tasks/getTaskStatuses', 'StatusController@getTaskStatuses');

    Route::apiResources([ 'tasks' => 'TaskController' ]);
    Route::apiResources([ 'tasks/status' => 'StatusController' ]);
});

Route::group([
    'namespace' => 'API\Projects',
    'as' => 'projects.'
], function () {
    Route::apiResources([ 'projects' => 'ProjectController' ]);
    Route::apiResources([ 'projects/status' => 'StatusController' ]);
});



