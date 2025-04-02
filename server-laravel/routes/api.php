<?php

use App\Http\Controllers\Api\CoopController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'hello world',
    ]);
});

// Manual routes for Coop REST API
Route::get('/coops', [CoopController::class, 'index']); // Get all coops
Route::post('/coops', [CoopController::class, 'store']); // Create a new coop
Route::get('/coops/{id}', [CoopController::class, 'show']); // Get a specific coop
Route::put('/coops/{id}', [CoopController::class, 'update']); // Update a specific coop
Route::delete('/coops/{id}', [CoopController::class, 'destroy']); // Delete a specific coop



// notifications
Route::post('/users/{id}/notify', [NotificationController::class, 'sendNotification']); // Send notification to a user


// ambil semua notifikasi user
Route::get('/users/{id}/notifications', [NotificationController::class, 'getUserNotifications']); // Get all notifications for a user


// menandai semua sebagai sudah dibaca
Route::put('/users/{id}/notifications/read', [NotificationController::class, 'markNotificationsAsRead']); // Mark notifications as read


// skema gacor
