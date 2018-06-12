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
Route::get('/activity', 'HomeController@activity'); // Activity Feed.


/*
* User routes
*/
Route::get('users/{user}', 'UserController@show');
Route::get('users/{user}/edit', 'UserController@edit');
Route::patch('users/{user}', 'UserController@update');

Route::post('search', 'UserController@search');

Route::post('users/{user}/follow', 'UserController@follow');
Route::post('users/{user}/unfollow', 'UserController@unfollow');

Route::get('oauth/{provider}', 'FacebookLoginController@redirect');
Route::get('oauth/{provider}/callback', 'FacebookLoginController@callback');


/*
* Tweet routes
*/

Route::post('/tweet/{user}', 'TweetController@create');
Route::delete('/tweet/{user}/{tweet}', 'TweetController@delete');
Route::get('/like/{tweet}', 'TweetController@like');
Route::get('/unlike/{tweet}', 'TweetController@unlike');