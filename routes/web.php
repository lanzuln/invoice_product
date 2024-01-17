<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.index');
});
Route::controller(InvoiceController::class)->group(function () {
    route::get('/all-invoice', 'all_invoice');
    route::get('/create-invoice', 'create_invoice')->name('invoice.create');
    route::post('/store-invoice', 'store_invoice');
});

Route::get('/customer-list', [CustomerController::class, 'CustomerList']);
Route::get('/product-list', [ProductController::class, 'allProductList']);
