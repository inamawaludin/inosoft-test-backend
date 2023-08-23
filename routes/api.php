<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalesController;
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

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class,'login'])->name('v1.login');
    Route::post('/register', [AuthController::class,'register'])->name('v1.register');
    
    Route::middleware('jwt.verify')->post('/logout', [AuthController::class,'logout'])->name('v1.logout');

    Route::prefix('/sales')->middleware('jwt.verify')->group(function(){
        Route::post('/record-sale',[SalesController::class, 'recordSale'])->name('v1.sales.create-sale');
        Route::get('/generate-sales-report',[SalesController::class, 'generateSalesReport'])->name('v1.sales.generate-report');
        Route::get('/view-stocks',[SalesController::class, 'viewStocks'])->name('v1.sales.view-available-stocks');
    });


});