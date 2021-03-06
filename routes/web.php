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

// Coupon route

Route::get('coupon', 'CouponController@index');

Route::post('coupon', 'CouponController@store');

Route::get('coupon/{id}', 'CouponController@show');

Route::put('coupon/{id}', 'CouponController@update');

Route::put('coupon/{id}', 'CouponController@update');

Route::delete('coupon/{id}', 'CouponController@destroy');

// Coupon Shop route

Route::get('coupon/{id}/shops', 'CouponController@couponShop');

Route::post('coupon/{id}/shops', 'CouponController@CreateCuponShop');

Route::get('coupon/{coupon_id}/shops/{shop_id}', 'CouponController@couponShopFilter');

Route::delete('coupon/{coupon_id}/shops/{id}', 'CouponController@deleteCouponShop');


//  Shop Route

Route::get('shop', 'ShopController@index');

Route::post('shop', 'ShopController@store');

Route::get('shop/{id}', 'ShopController@show');

Route::put('shop/{id}', 'ShopController@update');

Route::put('shop/{id}', 'ShopController@update');

Route::delete('shop/{id}', 'ShopController@destroy');


