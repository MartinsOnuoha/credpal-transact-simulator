<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AccountController;

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

Route::get('/{any?}', PagesController::class);

Route::prefix('auth')->group(function () {
  Route::post('register', [AuthController::class, 'register'])->name('auth.register');
  Route::post('login', [AuthController::class, 'login'])->name('auth.login');
});

Route::prefix('app')->middleware('auth:sanctum')->group(function () {
  Route::get('wallet', [WalletController::class, 'getWallet'])->name('get.wallet');
  Route::get('user', [WalletController::class, 'getUserData'])->name('get.user');
  Route::post('id', [AccountController::class, 'addIdCard'])->name('add.id');
  Route::post('transfer', [WalletController::class, 'transfer'])->name('wallet.transfer');
});
