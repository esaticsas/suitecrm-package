<?php

use Illuminate\Support\Facades\Route;

Route::middleware('crm')->prefix('crm')->group(function () {
    Route::get('', [\Esatic\Suitecrm\Http\Controllers\AbstractController::class, 'getAvailableModules'])->name('api.crm.getAvailableModules');
    Route::get('{module}', [\Esatic\Suitecrm\Http\Controllers\AbstractController::class, 'getEntryList'])->name('api.crm.getEntryList');
    Route::get('{module}/entry/{moduleId}/{linkFieldName}', [\Esatic\Suitecrm\Http\Controllers\AbstractController::class, 'getRelationships'])->name('api.crm.getRelationships');
    Route::get('{module}/entry/{id}', [\Esatic\Suitecrm\Http\Controllers\AbstractController::class, 'getEntry'])->name('api.crm.getEntry');
    Route::get('{module}/fields', [\Esatic\Suitecrm\Http\Controllers\AbstractController::class, 'getModuleFields'])->name('api.crm.getModuleFields');
    Route::post('{module}', [\Esatic\Suitecrm\Http\Controllers\AbstractController::class, 'setEntry'])->name('api.crm.setEntry');
    Route::post('{module}/entries', [\Esatic\Suitecrm\Http\Controllers\AbstractController::class, 'setEntries'])->name('api.crm.setEntries');
    Route::post('{module}/entry/{moduleId}/{linkFieldName}', [\Esatic\Suitecrm\Http\Controllers\AbstractController::class, 'setRelationship'])->name('api.crm.setRelationship');
    Route::get('{module}/entries', [\Esatic\Suitecrm\Http\Controllers\AbstractController::class, 'getEntries'])->name('api.crm.getEntries');
});
