<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'index'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('owner')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class)
        ->only([
            'index',
            'show',
            'edit',
            'update'
    ]);
    Route::post('/products/attributes', [ProductController::class, 'storeAttribute'])->name('products.attributes.store');
    Route::put('/orders/{id}/update-production', [OrderController::class, 'updateProduction'])->name('orders.update-production');
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
    // Route::get('/reports/export', [ReportController::class, 'export'])
    //     ->name('reports.export');
    // Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])
    //     ->name('reports.export.pdf');
    // Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])
    //     ->name('reports.export.excel');
    // Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])
    //     ->name('reports.export.csv');
    // Route::get('/reports/export/print', [ReportController::class, 'exportPrint'])
    //     ->name('reports.export.print');
    /*
    |--------------------------------------------------------------------------
    | Profil Owner
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | Kelola Pelanggan
    |--------------------------------------------------------------------------
    */
    Route::resource('users', UserController::class)
        ->only([
            'index',
            'show',
            'edit',
            'update',
            'destroy'
        ]);

    Route::post('/logout', [AuthController::class, 'logout']);
});
