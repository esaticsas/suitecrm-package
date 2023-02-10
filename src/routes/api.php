<?php

use Esatic\Suitecrm\Http\Controllers\AbstractController;
use Esatic\Suitecrm\Http\Controllers\FileController;
use Esatic\Suitecrm\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

Route::middleware('crm')->prefix('crm')->group(function () {
    Route::get('', [AbstractController::class, 'getAvailableModules'])->name('api.crm.getAvailableModules');
    Route::get('{module}', [AbstractController::class, 'getEntryList'])->name('api.crm.getEntryList');
    Route::get('{module}/entry/{moduleId}/{linkFieldName}', [AbstractController::class, 'getRelationships'])->name('api.crm.getRelationships');
    Route::get('{module}/entry/{id}', [AbstractController::class, 'getEntry'])->name('api.crm.getEntry');
    Route::get('{module}/fields', [AbstractController::class, 'getModuleFields'])->name('api.crm.getModuleFields');
    Route::post('{module}', [AbstractController::class, 'setEntry'])->name('api.crm.setEntry');
    Route::post('{module}/entries', [AbstractController::class, 'setEntries'])->name('api.crm.setEntries');
    Route::post('{module}/entry/{moduleId}/{linkFieldName}', [AbstractController::class, 'setRelationship'])->name('api.crm.setRelationship');
    Route::get('{module}/entries', [AbstractController::class, 'getEntries'])->name('api.crm.getEntries');
    Route::post('', [AbstractController::class, 'genericRequest'])->name('api.crm.genericRequest');
    Route::get('relationships/{module}/{relationName}', [ModuleController::class, 'index'])->name('api.crm.relationships.index');
    Route::get('relationships/{module}/view/{id}', [ModuleController::class, 'view'])->name('api.crm.relationships.view');
    Route::get('relationships/{module}/view/{id}/{relationName}', [ModuleController::class, 'relationship'])->name('api.crm.relationships.relation');
    Route::post('files/{module}', [FileController::class, 'upload'])->name('crm.files.upload');
    Route::get('files/{module}/{id}', [FileController::class, 'download'])->name('crm.files.download');
    Route::get('entry-points/{entryPoint}', [AbstractController::class, 'getEntryPoint'])->name('crm.entry.points.get');
    Route::post('entry-points/{entryPoint}', [AbstractController::class, 'postEntryPoint'])->name('crm.entry.points.post');
});
