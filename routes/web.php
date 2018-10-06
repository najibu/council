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
Route::get('/home', 'HomeController@index');

Route::view('scan', 'scan');

// SearchController
Route::get('threads/search', 'SearchController@show')->name('threads.search');

// ThreadsController
Route::get('threads', 'ThreadsController@index')->name('threads');
Route::get('threads/create', 'ThreadsController@create');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
Route::patch('threads/{channel}/{thread}', 'ThreadsController@update');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::post('threads', 'ThreadsController@store')->middleware('must-be-confirmed');
Route::get('threads/{channel}', 'ThreadsController@index');


// LockedThreadsController
Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

// ThreadSubscriptionsController
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');


// RepliesController
Route::get('threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

// BestRepliesController
Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

// Channels

// FavoritesController
Route::post('replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('replies/{reply}/favorites', 'FavoritesController@destroy');

// ProfilesController
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');

// UserNotifications
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');

// RegisterConfirmationController
Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');

// Api UsersController
Route::get('api/users', 'Api\UsersController@index');

// Api UserAvatarController
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');
