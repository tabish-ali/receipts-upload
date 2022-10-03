<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\UsersController;
use App\Models\AccountSettings;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/get-receipts', [ReceiptController::class, 'getReceipts'])->middleware();
    Route::post('/set-receipt-status', [ReceiptController::class, 'setReceiptStatus'])->middleware();
    Route::get('/search-receipts', [ReceiptController::class, 'searchReceipts'])->middleware();

    Route::post('/set-account-settings', [AccountSettingsController::class, 'setAccountSettings'])->middleware();
    Route::get('/get-account-settings', [AccountSettingsController::class, 'getSettings'])->middleware();

    Route::post('/delete-receipt', [ReceiptController::class, 'deleteReceipt'])->middleware();

    Route::post('/update-profile', [UsersController::class, 'updateProfile'])->middleware();

    Route::get('/get-stats', [ReceiptController::class, 'getStats'])->middleware();
});
