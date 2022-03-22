<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('view1')->name('view1.')->group(function () {
    Route::get('/', 'View1Controller@index')->name('index');

    Route::prefix('ajax')->name('ajax.')->middleware(['checkAjax'])->group(function () {
        Route::get('/users', 'View1Controller@usersAjax')->name('users');
        Route::get('/centers', 'View1Controller@centersAjax')->name('centers');
        Route::delete('/users/{userId}/destroy', 'View1Controller@destroyUserAjax')->name('destroyUser');
    });

});

Route::prefix('view2')->name('view2.')->group(function () {
    Route::get('/', 'View2Controller@index')->name('index');

    Route::prefix('ajax')->name('ajax.')->middleware(['checkAjax'])->group(function () {
        Route::get('/users', 'View2Controller@usersAjax')->name('users');
        Route::get('/centers', 'View2Controller@centersAjax')->name('centers');
        Route::post('/users/store', 'View2Controller@storeAjax')->name('store');
    });

});
