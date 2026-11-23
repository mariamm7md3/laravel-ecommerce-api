<?php

use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\DeliverTimeController;
use App\Http\Controllers\Admin\DiscountCodesController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserMessageController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\DeliveryTimeController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/' , function(){
    return redirect('/login');
});
Route::get('/login',[AdminLoginController::class,'create'])->name('login');
Route::post('/login',[AdminLoginController::class,'store'])->name('login.store');


Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');
Route::middleware('auth')->group(function() {

    Route::get('/home',[AdminController::class,'index'])->name('home');

    Route::post('/logout',[AdminLoginController::class,'destroy'])->name('logout');
    Route::get('/profile',[AdminController::class,'show'])->name('profile');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    Route::patch('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])
        ->name('products.toggle-status');
    Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


//    variant


//    create
    Route::get('/products/{product}/variants/create' , [variantController::class, 'create'])->name('variants.create');
    Route::post('/products/{product}/variants' , [variantController::class, 'store'])->name('variants.store');

    Route::get('/variants/{variant}/edit' , [variantController::class, 'edit'])->name('variants.edit');
    Route::patch('/variants/{variant}' , [variantController::class, 'update'])->name('variants.update');

    Route::delete('/variants/{variant}', [variantController::class, 'destroy'])->name('variants.destroy');

    Route::get('/products/{product}/variants/create', [VariantController::class, 'create'])->name('variants.create');

    //Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
        ->name('categories.toggle-status');

    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // user
    Route::get('/users' , [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('users.toggle-status');

    Route::get('/users/{user}/edit' , [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('/users/create' , [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');



    Route::get('/users/{user}/addresses/create', [AddressController::class, 'create'])->name('address.create');
    Route::post('/users/{user}/addresses', [AddressController::class, 'store'])->name('address.store');

    Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::patch('/addresses/{address}', [AddressController::class, 'update'])->name('address.update');

    Route::patch('/addresses/{address}/toggle-status', [AddressController::class, 'toggleStatus'])
        ->name('address.toggle-status');

    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('address.destroy');


    Route::get('/messages' , [UserMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}' , [UserMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply' , [UserMessageController::class, 'reply'])->name('messages.reply');

    Route::delete('/messages/{message}', [UserMessageController::class, 'destroy'])->name('messages.destroy');


    Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.index');
    Route::get('/sizes/create', [SizeController::class, 'create'])->name('sizes.create');
    Route::post('/sizes', [SizeController::class, 'store'])->name('sizes.store');

    Route::get('/sizes/{size}/edit', [SizeController::class, 'edit'])->name('sizes.edit');
    Route::patch('/sizes/{size}', [SizeController::class, 'update'])->name('sizes.update');

    Route::patch('/sizes/{size}/toggle-status', [SizeController::class, 'toggleStatus'])->name('sizes.toggle-status');
    Route::delete('/sizes/{size}', [SizeController::class, 'destroy'])->name('sizes.destroy');


    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');

    Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit');
    Route::patch('/units/{unit}', [UnitController::class, 'update'])->name('units.update');

    Route::patch('/units/{unit}/toggle-status', [UnitController::class, 'toggleStatus'])->name('units.toggle-status');
    Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');

    Route::get('/sales' , [SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');

    Route::get('/sales/{sale}/edit', [SalesController::class, 'edit'])->name('sales.edit');
    Route::patch('/sales/{sale}', [SalesController::class, 'update'])->name('sales.update');

    Route::delete('/sales/{sale}', [SalesController::class, 'destroy'])->name('sales.destroy');

    Route::patch('sales/{sale}/toggle-status', [SalesController::class, 'toggleStatus'])->name('sales.toggle-status');

    Route::get('/orders' ,[OrderController::class, 'index'] )->name('orders.index');
    Route::patch('orders/{order}/update-status', [OrderController::class, 'updateStatus'])
        ->name('orders.update-status');

    Route::get('orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::delete('orders/{order}', [OrderController::class, 'destroy'])
        ->name('orders.destroy');


    Route::get('/branches' , [BranchController::class, 'index'] )->name('branches.index');
    Route::get('branches/create', [BranchController::class, 'create'])->name('branches.create');
    Route::post('branches', [BranchController::class, 'store'])->name('branches.store');
    Route::get('branches/{branch}/edit', [BranchController::class, 'edit'])->name('branches.edit');
    Route::put('branches/{branch}', [BranchController::class, 'update'])->name('branches.update');
    Route::delete('branches/{branch}', [BranchController::class, 'destroy'])->name('branches.destroy');


    Route::get('/industries' , [IndustryController::class, 'index'] )->name('industries.index');
    Route::get('/industries/create', [IndustryController::class, 'create'])->name('industries.create');
    Route::post('/industries', [IndustryController::class, 'store'])->name('industries.store');
    Route::get('/industries/{industry}/edit', [IndustryController::class, 'edit'])->name('industries.edit');
    Route::patch('/industries/{industry}', [IndustryController::class, 'update'])->name('industries.update');
    Route::delete('/industries/{industry}', [IndustryController::class, 'destroy'])->name('industries.destroy');

    Route::get('/delivery-times' , [DeliverTimeController::class, 'index'] )->name('delivery-times.index');
    Route::get('/delivery-times/create', [DeliverTimeController::class, 'create'])->name('delivery-times.create');
    Route::post('/delivery-times', [DeliverTimeController::class, 'store'])->name('delivery-times.store');
    Route::get('/delivery-times/{deliveryTime}/edit', [DeliverTimeController::class, 'edit'])->name('delivery-times.edit');
    Route::patch('/delivery-times/{deliveryTime}', [DeliverTimeController::class, 'update'])->name('delivery-times.update');
    Route::delete('/delivery-times/{deliveryTime}', [DeliverTimeController::class, 'destroy'])->name('delivery-times.destroy');
    Route::patch('/delivery-times/{deliveryTime}/toggle-status', [DeliverTimeController::class, 'toggleStatus'])
        ->name('delivery-times.toggle-status');


    Route::get('/discount-codes' , [DiscountCodesController::class, 'index'] )->name('discount-codes.index');
    Route::get('/discount-codes/create', [DiscountCodesController::class, 'create'])->name('discount-codes.create');
    Route::post('/discount-codes', [DiscountCodesController::class, 'store'])->name('discount-codes.store');
    Route::get('/discount-codes/{discountCode}/edit', [DiscountCodesController::class, 'edit'])->name('discount-codes.edit');
    Route::patch('/discount-codes/{discountCode}', [DiscountCodesController::class, 'update'])->name('discount-codes.update');
    Route::delete('/discount-codes/{discountCode}', [DiscountCodesController::class, 'destroy'])->name('discount-codes.destroy');
    Route::patch('/discount-codes/{discountCode}/toggle-status', [DiscountCodesController::class, 'toggleStatus'])
        ->name('discount-codes.toggle-status');


});

