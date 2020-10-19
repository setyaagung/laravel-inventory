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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::namespace('Admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('supplier', 'SupplierController');
    Route::resource('product', 'ProductController');
    Route::resource('purchase', 'PurchaseController');
    Route::get('/purchase/product/{supplier}', 'PurchaseController@getProduct');
    Route::get('/purchase/approved/{purchase}', 'PurchaseController@approved')->name('purchase.approved');
    Route::delete('/purchase/detail/{purchase_detail}', 'PurchaseController@destroy_detail')->name('purchase.destroy_detail');
    Route::resource('goodreceipt', 'GoodReceiptController');
    Route::post('/goodreceipt/{goodreceipt}', 'GoodReceiptController@approved')->name('goodreceipt.approved');
    Route::resource('sale', 'SaleController');
    Route::get('/sale/filter', 'SaleController@filter')->name('sale.filter');
    //cart
    Route::post('/sale/addproduct/{product}', 'SaleController@addProduct')->name('sale.addproduct');
    Route::delete('/sale/removeproduct/{product}', 'SaleController@removeProduct')->name('sale.removeproduct');
    Route::post('/sale/updatecart/{product}', 'SaleController@updatecart')->name('sale.updatecart');
    Route::post('/sale/clear', 'SaleController@clear')->name('sale.clear');
    Route::post('/sale/pay', 'SaleController@pay')->name('sale.pay');
    //nomor nota
    Route::get('/sale/invoice/{invoice}', 'SaleController@invoice')->name('sale.invoice');
    //profil perusahaan
    Route::get('/company', 'CompanyController@index')->name('company.index');
    Route::patch('/company/{company}', 'CompanyController@update')->name('company.update');
});
