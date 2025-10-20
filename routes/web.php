<?php

use App\Http\Controllers\OverviewController;
use App\Http\Controllers\CheckoutProcessController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/checkoutprocess',[CheckoutProcessController::class,'checkoutprocess']);

// Route::middleware(['auth:sanctum'])->group(function(){
//     Route::post('/checkoutprocess',[ProductsController::class,'checkoutprocess']);

// });
Route::get('/checkoutprocess/success',[CheckoutProcessController::class,'success_stripe']);
Route::get('/checkoutprocess/cancel',[CheckoutProcessController::class,'cancel']);
Route::get('/checkoutprocess/cancel',[CheckoutProcessController::class,'cancel']);
    


Route::get('/admin_overview',[OverviewController::class,'index']);
