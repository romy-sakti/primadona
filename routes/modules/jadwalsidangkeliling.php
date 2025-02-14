<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JadwalsidangkelilingController as ApiController;
use App\Http\Controllers\JadwalsidangkelilingController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('jadwalsidangkelilings', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('jadwalsidangkelilings/print', [WebController::class, 'exportPrint'])->name('jadwalsidangkelilings.print');
    Route::get('jadwalsidangkelilings/pdf', [WebController::class, 'pdf'])->name('jadwalsidangkelilings.pdf');
    Route::get('jadwalsidangkelilings/csv', [WebController::class, 'csv'])->name('jadwalsidangkelilings.csv');
    Route::get('jadwalsidangkelilings/json', [WebController::class, 'json'])->name('jadwalsidangkelilings.json');
    Route::get('jadwalsidangkelilings/excel', [WebController::class, 'excel'])->name('jadwalsidangkelilings.excel');
    Route::get('jadwalsidangkelilings/import-excel-example', [WebController::class, 'importExcelExample'])->name('jadwalsidangkelilings.import-excel-example');
    Route::post('jadwalsidangkelilings/import-excel', [WebController::class, 'importExcel'])->name('jadwalsidangkelilings.import-excel');
    Route::resource('jadwalsidangkelilings', WebController::class);
});
