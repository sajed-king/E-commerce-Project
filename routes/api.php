<?php

use App\Http\Controllers\Admin_OrdersController;
use App\Http\Controllers\Admin_ProductsController;
use App\Http\Controllers\Admin_SettingsController;
use App\Http\Controllers\Admin_User;
use App\Http\Controllers\Admin_UserController;
use App\Http\Controllers\Admin_UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutProcessController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReviewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminsOnly;
use App\Http\Middleware\OrderPaid;
use App\Http\Controllers\ChangeRoleController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/forgot_password',[AuthController::class,'sendResetLinkEmail']);
Route::post('/reset_password',[AuthController::class,'resetPassword'])->name('password.reset');

Route::get('/product',[ProductsController::class,'index']);
Route::get('/product/{product}',[ProductsController::class,'show']);
Route::get('/shipping_information',[CheckoutProcessController::class,'shipping_information']);
Route::get('/need_prescription/{product}',[CheckoutProcessController::class,'need_prescription']);



Route::group(['middleware'=>['auth:sanctum']],function(){
Route::post('/logout',[AuthController::class,'logout']);
Route::get('/order_details/{order}',[Admin_UsersController::class,'order_details']);
Route::post('/checkoutprocess',[CheckoutProcessController::class,'check']);
Route::post('/shipping_information',[CheckoutProcessController::class,'shipping_information'])->middleware(['auth:sanctum','OrderPaid']);
Route::post('/paymentprocess/{order}',[CheckoutProcessController::class,'paymentprocess']);
Route::put('/updatepassword',[Admin_SettingsController::class,'updatepassword']);
Route::get('/getprofile',[Admin_SettingsController::class,'getprofile']);
Route::put('/updateprofile',[Admin_SettingsController::class,'updateprofile']);
Route::post('/create_review/{product_id}',[ReviewsController::class,'store']);
Route::put('/update_review/{review}',[ReviewsController::class,'update']);
Route::delete('/delete_review/{review}',[ReviewsController::class,'destroy']);
Route::post('/coupons',[CouponController::class,'apply'],);
});



Route::middleware(['auth:sanctum', 'admin'])->group(function(){

Route::post('/product/store',[ProductsController::class,'store']);
Route::delete('/product/delete/{product}',[ProductsController::class,'destroy']);
Route::get('/admin_orders',[Admin_OrdersController::class,'orders']);
Route::get('/admin_overview',[OverviewController::class,'index']);
Route::get('/admin_sales',[OverviewController::class,'sales']);
Route::post('change_role/{user}',[ChangeRoleController::class ,'change_role']);
Route::get('/admin_products',[Admin_ProductsController::class,'index']);
Route::get('/admin_users',[Admin_UsersController::class,'index']);
Route::post('/product/update/{product}',[ProductsController::class,'update']);
Route::get('/delivery',[DeliveryController::class,'delivery']);                                                                                                                                                                                 
});  




// Route::get('/search/{search}',[ProductsController::class,'index']);
// Route::post('/checkoutprocess',[ProductsController::class,'checkoutprocess']);
// Route::post('/checkoutprocess/success',[ProductsController::class,'success'])->name('checkoutprocess.success');
// Route::post('/checkoutprocess/cancel',[ProductsController::class,'cancel'])->name('checkoutprocess.cancel');
// Route::middleware(['auth:sanctum', 'role:admin'])->get('/product/{product}',[] ); 
