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

use App\Http\Controllers\LikeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chat', 'ChatController@index');
Route::get('/usersdata', 'ShowController@show');
Route::get('/profile/{slug}', 'ProfileController@index');
Route::get('/profileData/{slug}', 'ProfileController@show');
Route::post('/profileUp/{id}', 'ProfileController@update');
Route::post('/postUpload', 'PostController@store');
Route::get('/posts', 'PostController@index');
Route::get('/ownposts/{id}', 'PostController@Userindex');

Route::post('/postUpdate/{id}', 'PostController@Update');
Route::delete('/delpost/{id}', 'PostController@remove');
Route::delete('/delLike/{id}', 'LikeController@remove');
Route::post('/addLike/{id}', 'LikeController@store');
Route::post('/upLike/{id}', 'LikeController@update');
Route::get('/Like/{id}', 'LikeController@Likes');
Route::post('/comment/{id}', 'CommentController@store');
Route::delete('/comment/{id}', 'CommentController@remove');
Route::post('/commentUp/{id}', 'CommentController@update');
Route::get('/comment/{id}', 'CommentController@index');
Route::post('/sendFriendRequest', 'FriendRequestController@store');

Route::get('/friends', 'FriendRequestController@index');
Route::delete('/delFriendRq/{id}', 'FriendRequestController@remove');
Route::delete('/delFriendRqsend/{id}', 'FriendRequestController@destroy');
Route::post('/addfriend', 'FriendRequestController@confirm');
Route::post('/delFriend', 'FriendsController@removefr');
Route::get('/onlineUsers', 'ChatController@onlineUser');

Route::post('/makeChat', 'ChatController@index1');
Route::get('/getChats/{id}', 'ChatController@chatCollection');
Route::get('/messages/{sessionKey}', 'MessageController@getMessage');
Route::post('/messageSend', 'MessageController@saveMessage');
