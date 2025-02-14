<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UploadpenetapanController as ApiController;
use App\Http\Controllers\UploadpenetapanController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('uploadpenetapans', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('uploadpenetapans/print', [WebController::class, 'exportPrint'])->name('uploadpenetapans.print');
    Route::get('uploadpenetapans/pdf', [WebController::class, 'pdf'])->name('uploadpenetapans.pdf');
    Route::get('uploadpenetapans/csv', [WebController::class, 'csv'])->name('uploadpenetapans.csv');
    Route::get('uploadpenetapans/json', [WebController::class, 'json'])->name('uploadpenetapans.json');
    Route::get('uploadpenetapans/excel', [WebController::class, 'excel'])->name('uploadpenetapans.excel');
    Route::get('uploadpenetapans/import-excel-example', [WebController::class, 'importExcelExample'])->name('uploadpenetapans.import-excel-example');
    Route::post('uploadpenetapans/import-excel', [WebController::class, 'importExcel'])->name('uploadpenetapans.import-excel');
    Route::resource('uploadpenetapans', WebController::class);
});
