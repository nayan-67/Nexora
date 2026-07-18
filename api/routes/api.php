<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(ApiController::class)->group(function () {
    Route::get('/categories', 'categories');
    Route::get('/sortcategories', 'sortcategories');
    Route::get('/products', 'products');
    Route::get('/products/{id}', 'productDetails');
    Route::get('/products/category/{slug}', 'productsByCategory');
    Route::get('/attr', 'attr');
    Route::get('/product/variants', 'prdVariants');
    Route::get('/variant-attribute', 'variantAttr');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::controller(ApiController::class)->group(function () {
        Route::get('/profile', 'profile');
        Route::post('/profile/update', 'updateprofile');
        Route::get('/cart', 'cart');
        Route::post('/cart/add', 'addCart');
        Route::post('/card/update', 'updateCart');
        Route::post('/card/remove', 'removeCart');
        Route::get('/address', 'address');
        Route::post('/address/create', 'addAddr');
        Route::get('/address/default/{id}', 'updateDefault');
        Route::get('/address/{id}', 'addressData');
        Route::post('/address/update', 'updateAddr');
        Route::post('/order/create', 'createOrder');
        Route::get('/order/{id}', 'orderData');
        Route::get('/wishlist', 'wishlist');
        Route::post('/wishlist/add', 'addWish');
        Route::get('/applydiscount/{code}', 'applyDiscount');
        Route::get('/userorders', 'userOrder');
        Route::get('/orderitems/{id}', 'orderItems');
        Route::get('/orderproducts', 'orderProducts');
    });
});
