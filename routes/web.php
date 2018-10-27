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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'MicropostsController@index');


Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup','Auth\RegisterController@register')->name('signup.post');

//ログイン認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

// ログイン認証付きルーティング　ユーザー一覧/詳細
Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    Route::group(['prefix' => 'users/{id}'], function() {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        Route::get('favorites', 'UsersController@favorites')->name('users.favorites');
    });
    Route::resource('microposts','MicropostsController', ['only' => ['store', 'destroy']]);
    
    Route::group(['prefix' => 'micropost/{id}'], function(){
        Route::post('onfavor','UserFavoritesController@store')->name('micropost.onfavor');
        Route::delete('offfavor','UserFavoritesController@destroy')->name('micropost.offfavor');
    });
    
    
    /*
    Route::post('favoritepost','UserFavoritesController@store')->name('favoritepost.post');
    Route::delete('favoritepost','UserFavoritesController@destroy')->name('favoritepost.destroy');
    */
});
