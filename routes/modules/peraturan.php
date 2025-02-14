<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PeraturanController as ApiController;
use App\Http\Controllers\PeraturanController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('peraturans', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('peraturans/print', [WebController::class, 'exportPrint'])->name('peraturans.print');
    Route::get('peraturans/pdf', [WebController::class, 'pdf'])->name('peraturans.pdf');
    Route::get('peraturans/csv', [WebController::class, 'csv'])->name('peraturans.csv');
    Route::get('peraturans/json', [WebController::class, 'json'])->name('peraturans.json');
    Route::get('peraturans/excel', [WebController::class, 'excel'])->name('peraturans.excel');
    Route::get('peraturans/import-excel-example', [WebController::class, 'importExcelExample'])->name('peraturans.import-excel-example');
    Route::post('peraturans/import-excel', [WebController::class, 'importExcel'])->name('peraturans.import-excel');
    Route::resource('peraturans', WebController::class);
});
