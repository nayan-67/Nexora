<?php

use App\Http\Controllers\admin\Category;
use App\Http\Controllers\admin\Coupon;
use App\Http\Controllers\admin\Admin;
use App\Http\Controllers\admin\Customer;
use App\Http\Controllers\admin\Order;
use App\Http\Controllers\admin\Product;
use App\Http\Controllers\admin\Sub_category;
use Illuminate\Support\Facades\Route;

// ==================== Admin ====================
Route::controller(Admin::class)->group(function () {
    Route::get('/login', 'login')->name('admin.login');
    Route::get('/logout', 'logout')->name('admin.logout');
    Route::post('/login/check', 'logcheck')->name('admin.logcheck');

    Route::get('/', 'index')->name('dashboard');
    Route::get('/setting', 'setting')->name('admin.setting');
    Route::put('/update/{id}', 'update')->name('admin.update');
});

// ==================== Category ====================

Route::controller(Category::class)->group(function () {
    Route::get('/category', 'index')->name('admin.category');
    Route::get('/category/add', 'add')->name('category.add');
    Route::get('/category/edit/{id}', 'edit')->name('category.edit');
    Route::post('/category/store', 'store')->name('category.store');
    Route::put('/category/update/{id}', 'update')->name('category.update');
    Route::delete('/category/destroy', 'destroy')->name('category.destroy');
    Route::get('/category/search/{name}', 'search')->name('category.search');
});

// ==================== Sub_category ====================

Route::controller(Sub_category::class)->group(function () {
    Route::get('/subcategory', 'index')->name('admin.subcategory');
    Route::get('/subcategory/add', 'add')->name('subcategory.add');
    Route::get('/subcategory/edit/{id}', 'edit')->name('subcategory.edit');
    Route::post('/subcategory/store', 'store')->name('subcategory.store');
    Route::put('/subcategory/update/{id}', 'update')->name('subcategory.update');
    Route::delete('/subcategory/destroy', 'destroy')->name('subcategory.destroy');
    Route::get('/subcategory/search/{name}', 'search')->name('subcategory.search');
});

// ==================== Product ====================

Route::controller(Product::class)->group(function () {
    Route::get('/product', 'index')->name('admin.product');
    Route::get('/product/edit/{id}', 'edit')->name('product.edit');
    Route::get('/product/add/simple', 'add')->name('admin.simple-product');
    Route::get('/product/add/variable', 'addVariant')->name('admin.variable-product');
    Route::post('/product/store', 'store')->name('product.store');
    Route::post('/product/store/variant', 'storeVariant')->name('variant-product.store');
    Route::put('/product/update/simple/{id}', 'update')->name('product.simpleupdate');
    Route::put('/product/update/variable/{id}', 'variableupdate')->name('product.variableupdate');
    Route::delete('/product/destroy', 'destroy')->name('product.destroy');
    Route::get('/product/search/{name}', 'search')->name('product.search');
    Route::get('/product/subcat/{name}', 'searchsubcat')->name('product.subcat');
});


// ==================== Coupon ====================

Route::controller(Coupon::class)->group(function () {
    Route::get('/coupon', 'index')->name('admin.coupon');
    Route::get('/coupon/add', 'add')->name('coupon.add');
    Route::get('/coupon/edit/{id}', 'edit')->name('coupon.edit');
    Route::post('/coupon/store', 'store')->name('coupon.store');
    Route::put('/coupon/update/{id}', 'update')->name('coupon.update');
    Route::delete('/coupon/destroy', 'destroy')->name('coupon.destroy');
    Route::get('/coupon/search/{name}', 'search')->name('coupon.search');
});

// ==================== Order ====================

Route::controller(Order::class)->group(function () {
    Route::get('/order', 'index')->name('admin.order');
    Route::get('/order/edit/{id}', 'edit')->name('order.edit');
    Route::post('/order/store', 'store')->name('order.store');
    Route::put('/order/update/{id}', 'update')->name('order.update');
    Route::delete('/order/destroy', 'destroy')->name('order.destroy');
    Route::get('/order/search/{name}', 'search')->name('order.search');
});

// ==================== Customer ====================

Route::controller(Customer::class)->group(function () {
    Route::get('/customer', 'index')->name('admin.user');
    Route::get('/customer/view/{id}', 'view')->name('user.view');
    Route::put('/customer/update/{id}', 'update')->name('user.update');
    Route::delete('/customer/destroy', 'destroy')->name('user.destroy');
    Route::get('/customer/search/{name}', 'search')->name('user.search');
    Route::get('/customer/order/{id}', 'userOrder')->name('user.order');
    Route::delete('/customer/order/destroy', 'delorder')->name('order.delete');
});
