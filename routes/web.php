<?php

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
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function()
{
    return view('welcome');
});

Route::get('/my-teams-and-players', function()
{
    return view('my-teams-and-players');
});
