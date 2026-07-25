<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WorkUnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ActivityLogController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Documents
    Route::resource('documents', DocumentController::class);
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // Admin Routes
    Route::middleware('can:category.view,workunit.view,user.view')->prefix('admin')->name('admin.')->group(function () {
        // Categories
        Route::resource('categories', CategoryController::class, ['as' => 'categories']);
        
        // Work Units
        Route::resource('work-units', WorkUnitController::class, ['as' => 'work-units']);
        
        // Users
        Route::resource('users', UserController::class, ['as' => 'users']);
        
        // Activity Logs
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });
});

auth()->routes();
