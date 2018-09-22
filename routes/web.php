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

Route::post('salaries/search', 'SalaryController@search')->name('salaries.search')->middleware('auth');
Route::post('salaries/{id}', 'SalaryController@restore')->name('salaries.restore')->middleware('auth');
Route::resource('salaries', 'SalaryController')->middleware('auth');

Route::get('payslip/form', 'SalaryController@payslipForm')->name('payslips.index')->middleware('auth');
Route::post('payslip', 'SalaryController@payslip')->name('payslips.show')->middleware('auth');
Route::post('payslip/print', 'SalaryController@payslipPrint')->name('payslips.print')->middleware('auth');

Route::resource('services', 'ServiceController')->middleware('auth');
Route::post('services/{id}', 'ServiceController@restore')->name('services.restore')->middleware('auth');

Route::resource('products', 'ProductController')->middleware('auth');
Route::post('products/{id}', 'ProductController@restore')->name('products.restore')->middleware('auth');

Route::post('sales/search', 'SaleController@search')->name('sales.search')->middleware('auth');
Route::resource('sales', 'SaleController')->middleware('auth');
Route::post('sales/{id}', 'SaleController@restore')->name('sales.restore')->middleware('auth');

Route::get('sales-details-report', 'ReportController@saleDetail')->name('report.sales-details')->middleware('auth');
Route::post('sales-details-report/search', 'ReportController@search')->name('report.sales-details-search')->middleware('auth');
Route::get('monthly-sales-report', 'ReportController@monthlySale')->name('report.monthly-sales')->middleware('auth');
Route::get('yearly-sales-report', 'ReportController@yearlySale')->name('report.yearly-sales')->middleware('auth');
Route::get('all-sales-report', 'ReportController@allSale')->name('report.all-sales')->middleware('auth');
Route::post('all-sales-report/search', 'ReportController@search')->name('report.all-sales-search')->middleware('auth');

Route::get('/dashboard', 'HomeController@index')->name('home');
