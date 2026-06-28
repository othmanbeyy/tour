<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TourController;
use App\Http\Controllers\SafariController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\TourManagementController;
use App\Http\Controllers\Admin\SafariManagementController;
use App\Http\Controllers\Admin\BlogManagementController;
use App\Http\Controllers\Admin\BookingManagementController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewManagementController;

// ─── Public Routes ──────────────────────────────────────────────────
Route::get('/tours', [TourController::class, 'index']);
Route::get('/tours/{id}', [TourController::class, 'show']);

Route::get('/safaris', [SafariController::class, 'index']);
Route::get('/safaris/{id}', [SafariController::class, 'show']);

Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);

Route::post('/contact', [ContactController::class, 'store']);
Route::post('/booking', [BookingController::class, 'store']);
Route::post('/analytics/visit', [AnalyticsController::class, 'store']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::get('/reviews', [ReviewController::class, 'index']);

// Friendly GET responses for POST-only endpoints
Route::get('/contact', fn() => response()->json(['message' => 'Contact submissions require POST requests to /api/contact.'], 200));
Route::get('/booking', fn() => response()->json(['message' => 'Bookings require POST requests to /api/booking.'], 200));

// ─── Admin Auth ─────────────────────────────────────────────────────
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/login', fn() => response()->json(['message' => 'Login requires POST requests to /api/admin/login.'], 200));

// ─── Admin Protected Routes (stateless, token-based) ───────────────
Route::prefix('admin')->middleware(['admin.api'])->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout']);

    // Tours Management
    Route::apiResource('tours', TourManagementController::class);

    // Safaris Management
    Route::apiResource('safaris', SafariManagementController::class);

    // Blogs Management
    Route::apiResource('blogs', BlogManagementController::class);

    // Bookings Management
    Route::apiResource('bookings', BookingManagementController::class)->only(['index', 'show', 'update', 'destroy']);

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index']);

    // Reviews Management
    Route::apiResource('reviews', ReviewManagementController::class)->only(['index', 'show', 'update', 'destroy']);
});
