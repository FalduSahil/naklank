<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Common\CommonController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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

    /*Dropzone Routes*/
    Route::post('upload-images', [ProductController::class, 'uploadImages'])->name('uploadImages');
    Route::post('remove-temp-files', [ProductController::class, 'removeTempFiles'])->name('removeTempFiles');

    /*Logout Admin*/
    Route::post('logout-admin', [AdminAuthController::class, 'logout'])->name('logoutAdmin');
});