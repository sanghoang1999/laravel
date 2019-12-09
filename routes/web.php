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
Route::group(['prefix' => 'login'], function () {
    Route::get('/','Auth\LoginController@showloginForm')->name('loginCus');
    Route::post('/{id?}','Auth\LoginController@login');
});
Route::post('loginToComment','FrontendController@LoginToComment');
Route::post('logout','Auth\LoginController@logout')->name('logoutCus');
Route::get('search','FrontendController@search')->name('tiem-kiem');
Route::get('/','FrontendController@index');
Route::get('/detail/{id}/{slug}.html','FrontendController@getDetail');
Route::post('comment/{id_prod}','FrontendController@storeComment');
Route::resource('cart', 'CartController',['except'=>['show','create']]);
Route::get('cart/detail','CartController@detail')->name('cart.detail');
Route::post('cart/detail','CartController@Mail');
Route::get('complete','CartController@complete');
Route::group(['namespace'=>'Admin'],function() {
    Route::group(['prefix' => 'admin/login'], function () {
        Route::get('/','LoginController@showloginForm')->name('loginAdmin');
        Route::post('/','LoginController@login');
    });
    Route::post('admin/logout','LoginController@logout')->name('logoutAdmin');
    Route::group(['prefix' => 'admin'], function () {
        Route::get('home','HomeController@index')->name('home');
    });
    Route::group(['prefix' => 'admin'], function () {
        Route::resource("category",'CategoryController');
        Route::resource('product', 'ProductController');
    });
});
Route::get('/category/{id}/{slug}.html','FrontendController@getProdByCate');
Route::get('facebook/redirect','AuthFacebookController@redirect');
Route::get('facebook/callback','AuthFacebookController@callback');
