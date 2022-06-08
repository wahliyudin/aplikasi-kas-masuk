<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AccountTypeController;
use App\Http\Controllers\Admin\CashInController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\HomeController;
use App\Models\Account;
use App\Models\CashIn;
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
    // return view('admin.cash-in.create');
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
        Route::prefix('data-siswa')->name('students.')->group(function () {
            Route::get('/', [StudentController::class, 'index'])->name('index');
        });
    });

    Route::prefix('Kas-masuk')->name('cash-ins.')->group(function () {
        Route::get('/', [CashInController::class, 'index'])->name('index');
        Route::get('create', [CashInController::class, 'create'])->name('create');
        Route::get('{id}/edit', [CashInController::class, 'edit'])->name('edit');
        Route::get('{id}/show', [CashInController::class, 'show'])->name('show');
        Route::get('exports/{id}/bukti-kas-masuk', [CashInController::class,
        'buktiKasMasuk'])->name('exports.bukti-kas-masuk');
    });

    Route::prefix('laporan')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('kas-masuk/export', [ReportController::class, 'kasMasukExport'])->name('kas-masuk.export');
    });
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');


require __DIR__ . '/auth.php';
