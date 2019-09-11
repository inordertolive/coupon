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

Route::get('/coupon', 'CouponController@index');   //领取优惠卷页面
Route::get('/draw', 'CouponController@draw');   //领取优惠卷执行页面
Route::get('/pcenter', 'CouponController@pcenter');   //个人中心
