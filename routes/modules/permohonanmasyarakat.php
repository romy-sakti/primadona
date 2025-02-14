<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PermohonanmasyarakatController as ApiController;
use App\Http\Controllers\PermohonanmasyarakatController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('permohonanmasyarakats', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('permohonanmasyarakats/print', [WebController::class, 'exportPrint'])->name('permohonanmasyarakats.print');
    Route::get('permohonanmasyarakats/pdf', [WebController::class, 'pdf'])->name('permohonanmasyarakats.pdf');
    Route::get('permohonanmasyarakats/csv', [WebController::class, 'csv'])->name('permohonanmasyarakats.csv');
    Route::get('permohonanmasyarakats/json', [WebController::class, 'json'])->name('permohonanmasyarakats.json');
    Route::get('permohonanmasyarakats/excel', [WebController::class, 'excel'])->name('permohonanmasyarakats.excel');
    Route::get('permohonanmasyarakats/import-excel-example', [WebController::class, 'importExcelExample'])->name('permohonanmasyarakats.import-excel-example');
    Route::post('permohonanmasyarakats/import-excel', [WebController::class, 'importExcel'])->name('permohonanmasyarakats.import-excel');
    Route::resource('permohonanmasyarakats', WebController::class);
});
