<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MidtransController;

// use App\Models\User;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('register', [UserController::class, 'register']);
// Route::post('login', [UserController::class, 'login']);


/**
 * contoh food market
 */
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('user', [UserController::class, 'fetch']);
//     Route::post('user', [UserController::class, 'updateProfile']);
//     Route::post('user/photo', [UserController::class, 'updatePhoto']);
//     Route::post('logout', [UserController::class, 'logout']);

//     Route::post('checkout', [TransactionController::class, 'checkout']);

//     Route::get('transaction', [TransactionController::class, 'all']);
//     Route::post('transaction/{id}', [TransactionController::class, 'update']);
// });

// Route::post('login', [UserController::class, 'login']);
// Route::post('register', [UserController::class, 'register']);

// Route::get('food', [FoodController::class, 'all']);
// Route::post('midtrans/callback', [MidtransController::class, 'callback']);

// Route::post('payment/notification', [MidtransController::class, 'callback']);

// Route::get('user', function(){
//     return "API User";
// });
