<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeliveryTimeController;
use App\Http\Controllers\FcmTokenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymobWebhookController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistItemController;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(SetLocale::class)->group(function () {

    Route::post('/register',[AuthController::class ,'store']);
    Route::post('/login',[AuthController::class ,'login']);

    Route::get('/home',HomeController::class);
    Route::get('/categories',[CategoryController::class,'index']);
    Route::get('/categories/{category}',[CategoryController::class,'show']);

    Route::get('/products',[ProductController::class,'index']);

    Route::get('/products/test-ai-filters', [ProductSearchController::class, 'searchNaturalLang']);
    Route::get('/products/search-ai', [ProductSearchController::class, 'search']);

    Route::get('/products/{product}',[ProductController::class,'show']);

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

    Route::get('/contact-info' , [ContactController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {


        Route::post('/fcm-token' , [FcmTokenController::class, 'store']);


        Route::post('/email/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return response()->json(['message' => 'Verification link sent']);
        });


//    هيشتغل بس على postman
        Route::get('/verify-email/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return response()->json(['message' => 'Email verified']);
        })->middleware('signed')->name('verification.verify');

        Route::get('/profile', [UserController::class, 'show']);
        Route::patch('/profile', [UserController::class, 'update']);
        Route::patch('/profile/password', [UserController::class, 'changePassword']);
        Route::delete('/profile', [UserController::class, 'destroy']);

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::middleware('verified')->group(function () {

            Route::apiResource('addresses', AddressController::class);
            Route::patch('/addresses/{address}/set-main', [AddressController::class, 'setMain']);

            Route::get('/wishlist',[WishlistItemController::class,'index']);
            Route::post('/wishlist/items',[WishlistItemController::class,'store']);
            Route::delete('/wishlist/items/{item}',[WishlistItemController::class,'destroy']);


            Route::get('/cart',[CartItemController::class,'index']);
            Route::post('/cart/items',[CartItemController::class,'store']);
            Route::delete('/cart/items/{item}',[CartItemController::class,'destroy']);
            Route::patch('/cart/items/{item}',[CartItemController::class,'update']);
            // ببعت ال id ال في ال cart_items

            Route::get('/delivery-times' , [DeliveryTimeController::class,'index']);

            Route::get('/orders',[OrderController::class,'index']);
            Route::get('/orders/{order}',[OrderController::class,'show']);
            Route::post('/orders',[OrderController::class,'store']);

            Route::post('/orders/{order}/rate', [RateController::class, 'store']);

            Route::patch('/messages' , [ContactController::class, 'store']);

        });

    });

    Route::post('/webhooks/paymob' , [PaymobWebhookController::class, 'handle']);


});




