<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Productivity Improvements
|--------------------------------------------------------------------------
|
| These commands will help to improve productivity while working on your
| application. As the namespace implies, they are only used while debugging
| or when your application APP_ENV is not set to production.
|
*/

\App\Debug\ArtisanDebug::clearViews();

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

Route::group(['middleware' => 'auth:api'], function()
{
    Route::get('/teams', 'Api\Team\TeamApi@get');
    Route::put('/teams', 'Api\Team\TeamApi@put');
    Route::put('/teams/{team_id}/player', 'Api\Team\PlayerApi@put');
    Route::patch('/teams/{team_id}/player/{player_id}', 'Api\Team\PlayerApi@patch');
});
