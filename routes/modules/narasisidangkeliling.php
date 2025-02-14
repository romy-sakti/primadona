<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NarasisidangkelilingController as ApiController;
use App\Http\Controllers\NarasisidangkelilingController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('narasisidangkelilings', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('narasisidangkelilings/print', [WebController::class, 'exportPrint'])->name('narasisidangkelilings.print');
    Route::get('narasisidangkelilings/pdf', [WebController::class, 'pdf'])->name('narasisidangkelilings.pdf');
    Route::get('narasisidangkelilings/csv', [WebController::class, 'csv'])->name('narasisidangkelilings.csv');
    Route::get('narasisidangkelilings/json', [WebController::class, 'json'])->name('narasisidangkelilings.json');
    Route::get('narasisidangkelilings/excel', [WebController::class, 'excel'])->name('narasisidangkelilings.excel');
    Route::get('narasisidangkelilings/import-excel-example', [WebController::class, 'importExcelExample'])->name('narasisidangkelilings.import-excel-example');
    Route::post('narasisidangkelilings/import-excel', [WebController::class, 'importExcel'])->name('narasisidangkelilings.import-excel');
    Route::resource('narasisidangkelilings', WebController::class);
});