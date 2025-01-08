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
    return view('home');
 
});
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/account', [UserController::class, 'account'])->name('account');
Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/about-us', [AboutUsController::class, 'index'])->name('about_us');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/careers', [CareersController::class, 'index'])->name('careers');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

