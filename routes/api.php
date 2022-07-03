<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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

Route::group(['prefix' => 'products'], function () {
    Route::post('/', [ProductController::class, 'getAllProducts'])->name('products.getAll');
    Route::post('/details', [ProductController::class, 'getProductDetails'])->name('products.getProductDetails');
    Route::get('/sort-by-options', [ProductController::class, 'getSortByOptions'])->name('products.getSortByOptions');
    Route::get('/imageGallery', [ProductController::class, 'getImageGallery'])->name('products.getImageGallery');
});

Route::group(['middleware' => ['auth:sanctum','abilities:role-customer']], function () {
    Route::post('sign-out', [AuthController::class, 'signOut']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
