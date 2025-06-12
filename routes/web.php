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
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\PaymentController;

use App\Mail\BulkOrderMail;
use Illuminate\Support\Facades\Mail;

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


Route::get('/test-mail', function () {
    Mail::raw('Test email from Laravel', function ($message) {
        $message->to('fms.cool16@gmail.com')->subject('Laravel Mail Test');
    });

    return 'Mail sent!';
});
//Main pages
Route::get('/', function () {return view('home');});
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/account', [UserController::class, 'account'])->name('account');



Route::get('/about-us', [AboutUsController::class, 'index'])->name('about_us');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/careers', [CareersController::class, 'index'])->name('careers');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/products', [ProductController::class, 'index'])->name('products');

//All Products
Route::get('/products/category', [ProductController::class, 'category'])->name('products_main');//All Products
Route::get('/products/brands/{brand_id}/categories', [ProductController::class, 'brandCategories'])->name('products.byBrandCategories');
Route::get('/products/{category?}', [ProductController::class, 'show'])->name('products.show');//2nd categories
Route::get('/subcategories/product/{ProductID}', [ProductController::class, 'showByProducts'])->name('product.details');
Route::get('/subcategories/{subCategoryId}', [SubCategoryController::class, 'show'])->name('subcategory_product');//grid page
Route::get('/subcategory/{subCategoryId}', [SubCategoryController::class, 'applyFilters'])->name('subcategory_product');

Route::get('/filters', [SubCategoryController::class, 'getFilters'])->name('subcategory_filters');
// Route::get('/filters', [ProductController::class, 'fetchFilters'])->name('product.filter');
// Route::any('/api/applyFilters/{subCategoryId}', [ProductController::class, 'applyFilters'])->name('apply.filters');
 
//Home Products
Route::get('/', [HomeController::class , 'index'])->name('home');
Route::get('/products/{category}', [ProductController::class, 'showByCategory'])->name('products.category');
Route::get('/products/{category}', [ProductController::class, 'showCategories'])->name('products.category');
Route::get('/subcategories/{id}/products', [SubcategoryController::class, 'getProducts']); 
 
//Home brands
Route::get('/categories/manufacturer/{manufacturer}', [ProductController::class,'showByManufacturer'])->name('categories.show');

// Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Search
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Custom registration routes
Route::get('register', [RegisterController::class,'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class,'store']);

Route::get('/register/vendor', [RegisterController::class, 'showRegistrationVendor'])->name('vendor.register');
Route::post('/register/vendor', [RegisterController::class, 'store'])->name('vendor.register');

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

    

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    //order
    Route::any('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');
    Route::post('/bulk-order', [OrderController::class, 'handleBulkOrder'])->name('bulk.order');

    //Razorpay
    Route::post('/create-razorpay-order', [RazorpayController::class, 'createOrder']);

    //Payment
    Route::post('/razorpay-payment-success', [PaymentController::class, 'razorpaySuccess']);


    //Cart routes
    Route::any('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::patch('/cart/update/{itemId}', [CartController::class, 'updateItem'])->name('cart.update');
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/empty', [CartController::class, 'emptyCart'])->name('cart.empty');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');

});


//admin Dashboard
Route::get('/admin/dashboard', function () {
    return view('layouts/admin');
})->name('admin.dashboard');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    //products
    Route::get('/products', [ProductController::class, 'adminProducts'])->name('admin.products');
    Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::any('/admin/products/import', [ProductController::class, 'importExcel'])->name('admin.products.import');
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
    Route::any('/subcategories/store', [SubcategoryController::class, 'store'])->name('admin.subcategories.store');
    Route::get('/subcategories/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('admin.subcategories.edit');
    Route::put('/subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('admin.subcategories.update');
    Route::delete('/subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->name('admin.subcategories.delete');

    //orders
    Route::get('/orders', [OrderController::class, 'showOrders'])->name('admin.orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{id}/tracking', [OrderController::class, 'updateTracking'])->name('admin.orders.updateTracking');

    
});

Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'account'])->name('user.profile');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');

    Route::get('/orders', [OrderController::class, 'orderUser'])->name('user.orders.index');
    Route::get('/user/orders/{order_id}', [OrderController::class, 'userShow'])->name('user.orders.show');

    // Route::post('/logout', [LoginController::class, 'logout'])->name('user.logout');
});





Route::get('/test-mail-view', function () {
    return new BulkOrderMail([
        'quantity' => 10,
        'message' => 'Test message',
        'ProductID' => 1 // Ensure this ID exists in your database
    ]);
});

Route::post('/submit-payment', [PaymentController::class, 'submit']);
