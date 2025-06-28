<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-only routes
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('members', \App\Http\Controllers\MemberController::class);
    Route::get('members/{member}/renew', [\App\Http\Controllers\MemberController::class, 'renew'])->name('members.renew');
    Route::post('members/{member}/renew', [\App\Http\Controllers\MemberController::class, 'renewStore'])->name('members.renew.store');
    Route::get('members/{member}', [\App\Http\Controllers\MemberController::class, 'show'])->name('members.show');
    Route::get('members/{member}/invoice', [\App\Http\Controllers\MemberController::class, 'invoice'])->name('members.invoice');
    Route::get('/analytics', [App\Http\Controllers\AdminAnalyticsController::class, 'index'])->name('admin.analytics');
    Route::get('/admin/staff/create', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('admin.staff.create');
    Route::post('/admin/staff/store', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('admin.staff.store');

    // Staff management routes
    Route::get('/admin/staff', [\App\Http\Controllers\StaffController::class, 'index'])->name('admin.staff.index');
    Route::get('/admin/staff/{id}/edit', [\App\Http\Controllers\StaffController::class, 'edit'])->name('admin.staff.edit');
    Route::put('/admin/staff/{id}', [\App\Http\Controllers\StaffController::class, 'update'])->name('admin.staff.update');
    Route::delete('/admin/staff/{id}', [\App\Http\Controllers\StaffController::class, 'destroy'])->name('admin.staff.destroy');
});

// Staff-only routes
Route::middleware(['auth', RoleMiddleware::class . ':staff'])->group(function () {
    Route::get('/staff/dashboard', [\App\Http\Controllers\StaffDashboardController::class, 'index'])->name('staff.dashboard');
});

Route::post('/members/{member}/send-sms', [\App\Http\Controllers\MemberController::class, 'sendSms'])->name('members.sendSms');

require __DIR__.'/auth.php';
