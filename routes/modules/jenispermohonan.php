<?php

use App\Http\Middleware\EnsureAppKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JenispermohonanController as ApiController;
use App\Http\Controllers\JenispermohonanController as WebController;
use App\Http\Middleware\ViewShare;

# API
Route::prefix('api/v1')->as('api.')->middleware(['api', EnsureAppKey::class, 'auth:api'])->group(function () {
    Route::apiResource('jenispermohonans', ApiController::class);
});

# WEB
Route::middleware(['web', ViewShare::class, 'auth'])->group(function () {
    Route::get('jenispermohonans/print', [WebController::class, 'exportPrint'])->name('jenispermohonans.print');
    Route::get('jenispermohonans/pdf', [WebController::class, 'pdf'])->name('jenispermohonans.pdf');
    Route::get('jenispermohonans/csv', [WebController::class, 'csv'])->name('jenispermohonans.csv');
    Route::get('jenispermohonans/json', [WebController::class, 'json'])->name('jenispermohonans.json');
    Route::get('jenispermohonans/excel', [WebController::class, 'excel'])->name('jenispermohonans.excel');
    Route::get('jenispermohonans/import-excel-example', [WebController::class, 'importExcelExample'])->name('jenispermohonans.import-excel-example');
    Route::post('jenispermohonans/import-excel', [WebController::class, 'importExcel'])->name('jenispermohonans.import-excel');
    Route::resource('jenispermohonans', WebController::class);
});
