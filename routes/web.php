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

Route::get('/', function () {
    return redirect('home');
});

Auth::routes([
    'register'=>false
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'admin','prefix'=>'admin'], function(){
    Route::resource('/companies', 'CompaniesController');
    Route::resource('/employees', 'EmployeesController');

    Route::get('get/companies', 'CompaniesController@get_companies')->name('get.companies');
    Route::get('get/employees', 'EmployeesController@get_employees')->name('get.employees');
});
