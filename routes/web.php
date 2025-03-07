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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('json-stats', 'User\DashboardController@stats');

Route::namespace('User')
    ->name('user.')
    ->prefix('user')
    ->middleware('auth')
    ->group(function () {
        Route::resource('dashboard', 'DashboardController');
        //Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        //Route::get('dashboard/aggiungidose', 'DashboardController@create')->name('dashboard.create');
    });
