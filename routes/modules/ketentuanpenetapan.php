<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KetentuanpenetapanController as ApiController;
use App\Http\Controllers\KetentuanpenetapanController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('ketentuanpenetapans', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('ketentuanpenetapans/print', [WebController::class, 'exportPrint'])->name('ketentuanpenetapans.print');
    Route::get('ketentuanpenetapans/pdf', [WebController::class, 'pdf'])->name('ketentuanpenetapans.pdf');
    Route::get('ketentuanpenetapans/csv', [WebController::class, 'csv'])->name('ketentuanpenetapans.csv');
    Route::get('ketentuanpenetapans/json', [WebController::class, 'json'])->name('ketentuanpenetapans.json');
    Route::get('ketentuanpenetapans/excel', [WebController::class, 'excel'])->name('ketentuanpenetapans.excel');
    Route::get('ketentuanpenetapans/import-excel-example', [WebController::class, 'importExcelExample'])->name('ketentuanpenetapans.import-excel-example');
    Route::post('ketentuanpenetapans/import-excel', [WebController::class, 'importExcel'])->name('ketentuanpenetapans.import-excel');
    Route::resource('ketentuanpenetapans', WebController::class);
});
