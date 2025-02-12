<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\HomeController;




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

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/category', [ProductController::class, 'category'])->name('products_main');//All Products
Route::get('/products/{category?}', [ProductController::class, 'show'])->name('products.show');//2nd categories
Route::get('/subcategories/product/{ProductID}', [ProductController::class, 'showByProducts'])->name('product.details');


Route::get('/', [HomeController::class , 'index'])->name('home');
Route::get('/products/{category}', [ProductController::class, 'showByCategory'])->name('products.category');

Route::get('/subcategories/{subCategoryId}', [SubCategoryController::class, 'show'])->name('subcategory_product');//grid page
Route::post('/subcategories/{subCategoryId}/filter', [SubCategoryController::class,'filter'])->name('subcategory.filter');

Route::get('/categories/manufacturer/{manufacturer}', [ProductController::class,'showByManufacturer'])->name('categories.show');