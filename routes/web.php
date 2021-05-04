<?php

use App\Http\Controllers\Web\IndexController;
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

Route::get('/', [IndexController::class, 'view'])->name('welcome');

Route::middleware(['auth'])->group(function () {

    Route::middleware(['can:list-products'])->group(function () {
        Route::get('product/list', [ProductController::class, 'list']);
        Route::resource('product', ProductController::class)->except(['show', 'destroy']);
        Route::get('product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    });
    
});

Auth::routes([
    'login' => true,
    'register' => true,
    'reset' =>false,
    'verifiy' => false,
    'confirm' => false,
    ]);
