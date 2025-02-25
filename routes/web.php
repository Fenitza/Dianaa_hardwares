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
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\ResetPasswordController;

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

//Main pages
Route::get('/', function () {return view('home');});
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/account', [UserController::class, 'account'])->name('account');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about_us');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/careers', [CareersController::class, 'index'])->name('careers');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/products', [ProductController::class, 'index'])->name('products');

//All Products
Route::get('/products/category', [ProductController::class, 'category'])->name('products_main');//All Products
Route::get('/products/{category?}', [ProductController::class, 'show'])->name('products.show');//2nd categories
Route::get('/subcategories/product/{ProductID}', [ProductController::class, 'showByProducts'])->name('product.details');
Route::get('/subcategories/{subCategoryId}', [SubCategoryController::class, 'show'])->name('subcategory_product');//grid page
Route::post('/subcategories/{subCategoryId}/filter', [SubCategoryController::class,'filter'])->name('subcategory.filter');

//Home Products
Route::get('/', [HomeController::class , 'index'])->name('home');
Route::get('/products/{category}', [ProductController::class, 'showByCategory'])->name('products.category');

//Home brands
Route::get('/categories/manufacturer/{manufacturer}', [ProductController::class,'showByManufacturer'])->name('categories.show');

// Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Custom registration routes
Route::get('register', [RegisterController::class,'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class,'store']);

// Password Reset Routes
Route::get('password/reset',[ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
Route::post('password/email',[ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}',[ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


///careers
// Route::get('/careers', CareersController::class,'showCareersPage');


//Login Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', function () {
        return view('layouts/admin');
    })->name('admin.dashboard');

    // Add User dashboard route
    Route::get('/user/dashboard', function () {
        return view('layouts/user');  // Ensure 'user_dashboard.blade.php' exists in resources/views
    })->name('user.dashboard');
});


//admin Dashboard
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'adminProducts'])->name('admin.products');
    Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::get('/products/{id}', [ProductController::class, 'showProducts'])->name('admin.products.view');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('admin.products.update');
    Route::post('/products/{id}/delete', [ProductController::class, 'destroy'])->name('admin.products.delete');
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
});


//Cart routes
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');