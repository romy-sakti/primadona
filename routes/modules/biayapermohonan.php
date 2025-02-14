<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BiayapermohonanController as ApiController;
use App\Http\Controllers\BiayapermohonanController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('biayapermohonans', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('biayapermohonans/print', [WebController::class, 'exportPrint'])->name('biayapermohonans.print');
    Route::get('biayapermohonans/pdf', [WebController::class, 'pdf'])->name('biayapermohonans.pdf');
    Route::get('biayapermohonans/csv', [WebController::class, 'csv'])->name('biayapermohonans.csv');
    Route::get('biayapermohonans/json', [WebController::class, 'json'])->name('biayapermohonans.json');
    Route::get('biayapermohonans/excel', [WebController::class, 'excel'])->name('biayapermohonans.excel');
    Route::get('biayapermohonans/import-excel-example', [WebController::class, 'importExcelExample'])->name('biayapermohonans.import-excel-example');
    Route::post('biayapermohonans/import-excel', [WebController::class, 'importExcel'])->name('biayapermohonans.import-excel');
    Route::resource('biayapermohonans', WebController::class);
});
