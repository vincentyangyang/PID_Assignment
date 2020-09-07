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

Route::get('login','userController@login')->name('login');
Route::post('login','userController@loginPost')->name('loginPost');

Route::get('register','userController@register')->name('register');
Route::post('register','userController@registerPost')->name('registerPost');

Route::get('goodsList','userController@goodsList')->name('goodsList');

Route::get('goodsDetail','userController@goodsDetail')->name('goodsDetail');

Route::get('cart','userController@cart')->name('cart');
Route::post('cartPost','userController@cartPost')->name('cartPost');

Route::get('orders','userController@orders')->name('orders');

Route::post('addPost','userController@addPost')->name('addPost');


Route::prefix('admin')->group(function(){
    Route::get('login','adminController@login')->name('admin.login');
    Route::post('loginPost','adminController@loginPost')->name('admin.loginPost');

    Route::get('members','adminController@members')->name('admin.members');
    Route::get('member_orders','adminController@member_orders')->name('admin.member_orders');
    Route::get('goods','adminController@goods')->name('admin.goods');
    Route::get('goods_action','adminController@goods_action')->name('admin.goods_action');

    Route::post('edit','adminController@edit_good')->name('admin.edit');
    Route::post('add','adminController@add_good')->name('admin.add');
    Route::post('image_ajax','adminController@image_ajax')->name('admin.image_ajax');
});
