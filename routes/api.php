<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\ProductCategoryApiController;
use App\Http\Controllers\API\TransactionApiController;
use App\Http\Controllers\API\UserApiController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('products', [ProductApiController::class, 'all']);
Route::get('categories', [ProductCategoryApiController::class , 'all']);
Route::post('register', [UserApiController::class , 'register']);
Route::post('login', [UserApiController::class , 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', [UserApiController::class, 'fetch']);
    Route::post('user' , [UserApiController::class, 'updateProfile']);
    Route::post('logout' , [UserApiController::class, 'logout']);

    Route::get('transaction', [TransactionApiController::class, 'all']);
    Route::post('checkout', [TransactionApiController::class, 'checkout']);
});


