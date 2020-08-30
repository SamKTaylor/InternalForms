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

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/LdapTest', 'LdapTest@index');

Route::namespace('Forms')->prefix('Forms')->group(function () {

    Route::group(['prefix' => 'Complaints'], function () {
        Route::get('/', 'ComplaintsController@list');
        Route::get('/Json/{filter}', 'ComplaintsController@json');

        Route::get('/Add', 'ComplaintsController@add');
        Route::get('/Edit/{id}', 'ComplaintsController@edit');
        Route::get('/View/{id}', 'ComplaintsController@view');
        Route::post('/Save', 'ComplaintsController@save');

        Route::post('/Resolve', 'ComplaintsController@resolve');

        Route::get('/Acknowledge/{id}', 'ComplaintsController@acknowledge');

        Route::get('/CSV', 'ComplaintsController@csv');
    });

    Route::group(['prefix' => 'Returns'], function () {
        Route::get('/', 'ReturnsController@list');
        Route::get('/Json/{filter}', 'ReturnsController@json');
        Route::get('/Add', 'ReturnsController@add');
        Route::get('/Edit/{id}', 'ReturnsController@edit');
        Route::get('/View/{id}', 'ReturnsController@view');
        Route::post('/Save', 'ReturnsController@save');

        Route::post('/Receive', 'ReturnsController@receive');
        Route::post('/Inspected', 'ReturnsController@inspected');

        Route::post('/Resolve', 'ReturnsController@resolve');

        Route::get('/CSV', 'ReturnsController@csv');

    });

});