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
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ManufacturerController;

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
    return view('layouts/admin');
})->name('admin.dashboard');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    //products
    Route::get('/products', [ProductController::class, 'adminProducts'])->name('admin.products');
    Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::get('/products/{id}', [ProductController::class, 'showByProducts'])->name('admin.products.view');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::any('/products/{id}/update', [ProductController::class, 'update'])->name('admin.products.update');
    Route::any('/products/{id}/delete', [ProductController::class, 'destroy'])->name('admin.products.delete');
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    
    //categories
    Route::get('/categories', [CategoryController::class, 'admin_index'])->name('admin.categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::get('/products/{category}', [ProductController::class, 'show'])->name('admin.categories.show');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::any('/categories/{category}/update', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::any('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.delete');

    //manufacturers
    Route::get('/manufacturers', [ManufacturerController::class, 'index'])->name('admin.manufacturers');
    Route::get('/manufacturers/create', [ManufacturerController::class, 'create'])->name('admin.manufacturers.create');
    Route::post('/manufacturers', [ManufacturerController::class, 'store'])->name('admin.manufacturers.store');
    Route::get('/manufacturers/{manufacturer}/edit', [ManufacturerController::class, 'edit'])->name('admin.manufacturers.edit');
    Route::any('/manufacturers/{manufacturer}/update', [ManufacturerController::class, 'update'])->name('admin.manufacturers.update');
    Route::delete('/manufacturers/{manufacturer}', [ManufacturerController::class, 'destroy'])->name('admin.manufacturers.delete');

    // Subcategory Routes
    Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('admin.subcategories');
    Route::get('/subcategories/create', [SubcategoryController::class, 'create'])->name('admin.subcategories.create');
    Route::post('/subcategories', [SubcategoryController::class, 'store'])->name('admin.subcategories.store');
    Route::get('/subcategories/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('admin.subcategories.edit');
    Route::put('/subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('admin.subcategories.update');
    Route::delete('/subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->name('admin.subcategories.delete');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
});


//Cart routes
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{itemId}', [CartController::class, 'updateItem'])->name('cart.update');
Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::post('/cart/empty', [CartController::class, 'emptyCart'])->name('cart.empty');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');