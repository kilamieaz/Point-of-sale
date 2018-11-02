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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['middleware' => 'web'], function () {
    Route::get('user/profile', 'UserController@profile')->name('user.profile');
    Route::patch('user/{id}/change', 'UserController@changeProfile');

    Route::get('transaction/new', 'SalesDetailController@newSession')->name('transaction.new');
    Route::get('transaction/{id}/data', 'SalesDetailController@listData')->name('transaction.data');
    Route::get('transaction/printNota', 'SalesDetailController@printNota')->name('transaction.cetak');
    Route::get('transaction/notapdf', 'SalesDetailController@notaPDF')->name('transaction.pdf');
    Route::post('transaction/save', 'SalesDetailController@saveData');
    Route::get('transaction/loadform/{discount}/{total}/{beAccepted}', 'SalesDetailController@loadForm');
    Route::resource('transaction', 'SalesDetailController');
});

Route::group(['middleware' => ['web', 'checkUser:1']], function () {
    Route::get('category/data', 'CategoryController@listData')->name('category.data');
    Route::resource('category', 'CategoryController')->except('create', 'show');

    Route::get('product/data', 'ProductController@listData')->name('product.data');
    Route::post('product/delete', 'ProductController@deleteSelected');
    Route::post('product/print', 'ProductController@printBarcode');
    Route::resource('product', 'ProductController')->except('create', 'show');

    Route::get('supplier/data', 'SupplierController@listData')->name('supplier.data');
    Route::resource('supplier', 'SupplierController')->except('create', 'show');

    Route::get('member/data', 'MemberController@listData')->name('member.data');
    Route::post('member/print', 'MemberController@printCard');
    Route::resource('member', 'MemberController')->except('create', 'show');

    Route::get('expenses/data', 'ExpensesController@listData')->name('expenses.data');
    Route::resource('expenses', 'ExpensesController')->except('create', 'show');

    Route::get('user/data', 'UserController@listData')->name('user.data');
    Route::resource('user', 'UserController');

    Route::get('purchase/data', 'PurchaseController@listData')->name('purchase.data');
    Route::get('purchase/{id}/create', 'PurchaseController@create');
    Route::get('purchase/{id}/show', 'PurchaseController@show');
    Route::resource('purchase', 'PurchaseController');

    Route::get('purchase_detail/{id}/data', 'PurchaseDetailController@listData')->name('purchase_detail.data');
    Route::get('purchase_detail/loadform/{diskon}/{total}', 'PurchaseDetailController@loadForm');
    Route::resource('purchase_detail', 'PurchaseDetailController');

    Route::get('sales/data', 'SalesController@listData')->name('sales.data');
    Route::get('sales/{id}/show', 'SalesController@show');
    Route::resource('sales', 'SalesController');

    Route::get('report', 'ReportController@index')->name('report.index');
    Route::post('report', 'ReportController@refresh')->name('report.refresh');
    Route::get('report/data/{start}/{end}', 'ReportController@listData')->name('report.data');
    Route::get('report/pdf/{start}/{end}', 'ReportController@exportPDF');

    Route::resource('setting', 'SettingController');
});
