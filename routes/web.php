<?php

use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware(['auth'])->group(function () {
    Route::middleware(['can:list-products'])->group(function () {
        Route::get('product/list', [ProductController::class, 'list']);
        Route::resource('product', ProductController::class)->except(['show', 'destroy']);
        Route::get('product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    });

    Route::middleware(['can:list-orders'])->group(function () {
        Route::get('order', [OrderController::class, 'index'])->name('order.index');
        Route::get('order/list', [OrderController::class, 'list'])->name('order.list');
    });
});

Route::get('/', [IndexController::class, 'view'])->name('welcome');
Route::get('/item/{product:slug}', [ProductController::class, 'preview'])->name('product.preview');
Route::get('/order/{product:slug}', [OrderController::class, 'preview'])->name('order.preview');
Route::post('/order/{product:slug}', [OrderController::class, 'generate'])->name('order.generate');
Route::get('/order/check/{order:code}', [OrderController::class, 'check'])->name('order.check');

Route::post('searchOrder', [OrderController::class, 'search'])->name('order.search');

Auth::routes([
    'login' => true,
    'register' => true,
    'reset' =>false,
    'verifiy' => false,
    'confirm' => false,
    ]);
