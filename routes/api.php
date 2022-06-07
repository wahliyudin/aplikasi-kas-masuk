<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\AccountTypeController;
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

Route::name('api.')->group(function () {
    Route::prefix('account-types')->name('account-types.')->group(function () {
        Route::post('/', [AccountTypeController::class, 'index'])->name('index');
        Route::post('update-or-create', [AccountTypeController::class, 'updateOrCreate'])->name('update-or-create');
        Route::get('{id}/edit', [AccountTypeController::class, 'edit'])->name('edit');
        Route::delete('{id}/destroy', [AccountTypeController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::post('/', [AccountController::class, 'index'])->name('index');
        Route::post('update-or-create', [AccountController::class, 'updateOrCreate'])->name('update-or-create');
        Route::get('{id}/edit', [AccountController::class, 'edit'])->name('edit');
        Route::delete('{id}/destroy', [AccountController::class, 'destroy'])->name('destroy');
    });
});
