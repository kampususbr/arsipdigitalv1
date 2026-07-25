<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DocumentController as APIDocumentController;
use App\Http\Controllers\API\CategoryController as APICategoryController;
use App\Http\Controllers\API\StatisticsController;

Route::middleware('auth:sanctum')->group(function () {
    // Documents
    Route::apiResource('documents', APIDocumentController::class);
    Route::get('documents/{id}/download', [APIDocumentController::class, 'download']);

    // Categories
    Route::apiResource('categories', APICategoryController::class);

    // Statistics
    Route::get('statistics/overview', [StatisticsController::class, 'overview']);
    Route::get('statistics/documents-by-category', [StatisticsController::class, 'documentsByCategory']);
    Route::get('statistics/documents-trend', [StatisticsController::class, 'documentsTrend']);
});
