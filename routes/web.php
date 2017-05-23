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

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function(){
    CRUD::resource('customer', 'CustomersController');
    CRUD::resource('store', 'StoresController');
    CRUD::resource('store/{idStore}/employee', 'StoreEmployeesController');
    // CRUD::resource('store/{id}/contact', 'StoreContactsController');
});