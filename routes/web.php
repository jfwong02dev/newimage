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

// Route::get('/', ['middleware' => 'guest', function () {
//     return view('auth.login');
// }]);
Route::view('/', 'auth.login');

Auth::routes();

Route::resource('services', 'ServiceController');
Route::post('services/{id}', 'ServiceController@restore')->name('services.restore');

Route::get('/dashboard', 'HomeController@index')->name('home');
