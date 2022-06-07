<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AccountTypeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Models\Account;
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
    return Account::with('accountType')->oldest()->get();
    return redirect()->route('login');
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('master-data')->group(function () {
        Route::prefix('jenis-akun')->name('account-types.')->group(function () {
            Route::get('/', [AccountTypeController::class, 'index'])->name('index');
        });
        Route::prefix('data-akun')->name('accounts.')->group(function () {
            Route::get('/', [AccountController::class, 'index'])->name('index');
        });
    });
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');


require __DIR__ . '/auth.php';
