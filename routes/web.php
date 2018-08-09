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

Route::get('/', ['middleware' => 'guest', function () {
    return view('auth.login');
}]);

Auth::routes();

Route::resource('users', 'UserController')->middleware('auth');
Route::post('users/{id}', 'UserController@restore')->name('users.restore')->middleware('auth');

Route::resource('services', 'ServiceController')->middleware('auth');
Route::post('services/{id}', 'ServiceController@restore')->name('services.restore')->middleware('auth');

Route::resource('products', 'ProductController')->middleware('auth');
Route::post('products/{id}', 'ProductController@restore')->name('products.restore')->middleware('auth');;

Route::get('/dashboard', 'HomeController@index')->name('home');
