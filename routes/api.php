<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('sign-up', [AuthController::class, 'signUp'])->name('auth.signUp');

Route::post('sign-in', [AuthController::class, 'signIn'])->name('auth.signIn');

Route::get('account-options', [UserController::class, 'getAccountOptions'])->name('getAccountOptions');

Route::group(['prefix' => 'products'], function () {
    Route::post('/', [ProductController::class, 'getAllProducts'])->name('products.getAll');
    Route::post('/details', [ProductController::class, 'getProductDetails'])->name('products.getProductDetails');
    Route::get('/sort-by-options', [ProductController::class, 'getSortByOptions'])->name('products.getSortByOptions');
    Route::get('/imageGallery', [ProductController::class, 'getImageGallery'])->name('products.getImageGallery');
});

Route::group(['middleware' => ['auth:sanctum', 'abilities:role-customer']], function () {
    Route::post('sign-out', [AuthController::class, 'signOut'])->name('auth.signOut');

    Route::group(['prefix' => 'account'], function () {
        Route::post('details', [UserController::class, 'getAccountDetails'])->name('account.getDetails');
        Route::post('update', [UserController::class, 'updateAccountDetails'])->name('account.updateDetails');

        Route::group(['prefix' => 'address'], function () {
            Route::get('/', [AddressController::class, 'getAddressList'])->name('address.getAddressList');
            Route::get('modal-options', [AddressController::class, 'getAddressModalOptions'])->name('address.getModalOptions');
            Route::post('add', [AddressController::class, 'addAddress'])->name('address.add');
            Route::post('update', [AddressController::class, 'updateAddress'])->name('address.update');
            Route::post('delete', [AddressController::class, 'deleteAddress'])->name('address.delete');
        });
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
