<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Common\CommonController;
use App\Http\Controllers\Admin\Order\OrderController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Home\Auth\AuthController;
use App\Http\Controllers\Home\Checkout\CheckOutController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\Shop\ShopController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*Home*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*Shop*/
Route::get('products', [ShopController::class, 'shop'])->name('products');
Route::get('products/{slug}', [ShopController::class, 'getProduct'])->name('getProduct');

/*Category*/
Route::get('category/{slug?}', [ShopController::class, 'categories'])->name('categories');

/*Sorting*/
Route::post('sort-products', [ShopController::class, 'sortProducts'])->name('sortProducts');

/*Orders*/
Route::post('place-order', [CheckOutController::class, 'placeOrder'])->name('placeOrderWeb');

Route::match(['get', 'post'], 'product/search', [App\Http\Controllers\Home\Common\CommonController::class, 'search'])->name('search');

/*Clear Cache*/
Route::get('clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    return redirect()->back();
});

/*Optimize*/
Route::get('optimize', function () {
    Artisan::call('optimize');
    return redirect()->back();
});

/*Optimize Clear*/
Route::get('optimize-clear', function () {
    Artisan::call('optimize:clear');
    return redirect()->back();
});

Route::middleware('guest')->group(function () {
    /*Admin Login*/
    Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('loginAdmin');
    Route::post('admin/login', [AdminAuthController::class, 'login'])->name('adminLogin');
    Route::get('admin', function () {
        return redirect()->route('loginAdmin');
    });

    /*User Login*/
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('showForgotPassword');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword')->middleware('throttle:1,1');
    Route::post('login', [AuthController::class, 'login'])->name('userLogin');
    Route::post('check-email',[AuthController::class, 'checkEmail'])->name('checkEmail');
});

Route::middleware(['auth', 'userAccess:admin', 'PreventBackHistory'])->prefix('admin')->group(function () {
    /*Common Routes*/
    Route::get('datatable/{slug}', [CommonController::class, 'getDataTable'])->name('getDataTable');
    Route::post('update-status/{slug}', [CommonController::class, 'changeStatus'])->name('changeStatus');
    Route::post('get-labels', [CommonController::class, 'getLabels'])->name('getLabels');
    Route::post('logout-from-all', [CommonController::class, 'logoutFromAll'])->name('logoutFromAll');

    /*Validate Slug*/
    Route::post('validate-slug', [CommonController::class, 'validateSlug'])->name('validateSlug');

    /*Dashboard*/
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    /*Profile*/
    Route::get('profile', [CommonController::class, 'profile'])->name('adminProfile');
    Route::post('check-old-password', [CommonController::class, 'checkOldPassword'])->name('checkOldPassword');
    Route::post('update-profile', [CommonController::class, 'updateProfile'])->name('updateProfile');

    /*Users*/
    Route::resource('users', App\Http\Controllers\Admin\User\UserController::class);

    /*Check Duplicate Record*/
    Route::post('check-duplicate', [UserController::class, 'checkDuplicate']);

    /*Products*/
    Route::resource('products', App\Http\Controllers\Admin\Product\ProductController::class);
    Route::post('delete-product-image', [ProductController::class, 'removeImage'])->name('removeImage');

    /*Categories*/
    Route::resource('categories', App\Http\Controllers\Admin\Category\CategoryController::class);

    /*Orders*/
    Route::resource('orders', App\Http\Controllers\Admin\Order\OrderController::class);
    Route::post('update-order-status', [OrderController::class, 'updateOrderStatus'])->name('updateOrderStatus');
    /*For Add Order*/
    Route::post('fill-customer-details', [OrderController::class, 'fillCustomerDetails'])->name('fillCustomerDetails');

    /*Inquiries*/
    Route::resource('inquiries', App\Http\Controllers\Admin\Inquiry\InquiryController::class);

    /*For Edit Order*/
    Route::post('add-products-for-order', [OrderController::class, 'addProducts'])->name('addProducts');
    Route::post('check-quantity', [OrderController::class, 'checkQuantity'])->name('checkQuantity');
    Route::post('update-order', [OrderController::class, 'updateOrder'])->name('updateOrder');

    /*Dropzone Routes*/
    Route::post('upload-images', [ProductController::class, 'uploadImages'])->name('uploadImages');
    Route::post('remove-temp-files', [ProductController::class, 'removeTempFiles'])->name('removeTempFiles');

    /*Logout Admin*/
    Route::post('logout-admin', [AdminAuthController::class, 'logout'])->name('logoutAdmin');
});

Route::middleware(['auth', 'userAccess:user', 'PreventBackHistory'])->group(function () {

    /*Logout Admin*/
    Route::get('logout-user', [AuthController::class, 'logout'])->name('logoutUser');
});