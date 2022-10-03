<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\UsersController;

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

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/receipt-upload', [ReceiptController::class, 'upload']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware();
Route::get('/check-receipt-status', [ReceiptController::class, 'checkReceiptStatusView'])->name('check-receipt-status');
Route::post('/serach-receipt', [ReceiptController::class, 'searchReceipt']);
Route::get('/receipt-details/{receipt_id}', [ReceiptController::class, 'receiptDetailsView'])->middleware();
Route::get('/account-settings', [AccountSettingsController::class, 'settingsView'])->name('settings')->middleware();
Route::get('/profile-settings', [UsersController::class, 'profileView'])->name('profile')->middleware();
