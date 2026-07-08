<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Jobs\ProcessPodcast;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('login');
    Route::post('/authenticate', [AdminController::class, 'authenticate'])->name('authenticate');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        // Route::get('/dashboard', function () {
        //     return view('admin.dashboard');
        // })->name('dashboard');

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // category
        Route::get('/categories', [CategoryController::class, 'index'])->name('category');
        Route::get('/manage-category', [CategoryController::class, 'create'])->name('manage.category');
        Route::post('/add-category', [CategoryController::class, 'store'])->name('add.category');
        Route::get('/edit-category/{id}', [CategoryController::class, 'edit'])->name('edit.category');
        Route::post('/update-category/{id}', [CategoryController::class, 'update'])->name('update.category');
        Route::delete('/destory-category/{id}', [CategoryController::class, 'delete'])->name('destroy.category');
        Route::post('/category/status/{status}/{id}', [CategoryController::class, 'status'])->name('status.category');

        //product
        Route::get('/products', [ProductController::class, 'product'])->name('product');
        Route::get('/manage-product', [ProductController::class, 'manage_product'])->name('manage.product');
        Route::post('/add-product', [ProductController::class, 'add_product'])->name('add.product');
        Route::get('/edit-product/{id}', [ProductController::class, 'edit_product'])->name('edit.product');
        Route::post('/update-product/{id}', [ProductController::class, 'update_product'])->name('update.product');
        Route::get('/printbarcode/product', [ProductController::class, 'printbarcode'])->name('printbarcode.product');
        Route::get('/product/printbarcode/pdf/{id}', [ProductController::class, 'generateBarcodePdf'])->name('product.barcode.pdf');
        Route::delete('/destory-product/{id}', [ProductController::class, 'delete_product'])->name('destroy.product');

        //coupon
        Route::get('/coupons', [CouponController::class, 'index'])->name('coupons');
        Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
        Route::post('/coupons/store', [CouponController::class, 'store'])->name('coupons.store');
        Route::get('/coupons/edit/{id}', [CouponController::class, 'edit'])->name('coupons.edit');
        Route::post('/coupons/update/{id}', [CouponController::class, 'update'])->name('coupons.update');
        Route::post('/coupons/status/{status}/{id}', [CouponController::class, 'status'])->name('coupons.status');
        Route::delete('/coupons/delete/{id}', [CouponController::class, 'delete'])->name('coupons.delete');

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/admins', [AdminController::class, 'index']);

        //order
        Route::get('/orders', [OrderController::class, 'index'])->name('order');

        Route::get('/process', function () {
            // এটি জবটিকে সরাসরি রান না করে ব্যাকগ্রাউন্ড লাইনে পাঠিয়ে দেবে
            ProcessPodcast::dispatch();

            return "আপনার রিকোয়েস্ট নেওয়া হয়েছে! ব্যাকগ্রাউন্ডে কাজ চলছে।";
        });
    });
});
