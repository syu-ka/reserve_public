<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\Student\Auth\AuthenticatedSessionController as StudentLoginController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;

Route::prefix('student')->name('student.')->group(function () {
    Route::middleware('guest:student')->group(function () {
        Route::get('login', [StudentLoginController::class, 'create'])->name('login');
        Route::post('login', [StudentLoginController::class, 'store']);
    });

    Route::middleware('auth:student')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [StudentLoginController::class, 'destroy'])->name('logout');
    });
});

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminLoginController::class, 'create'])->name('login');
        Route::post('login', [AdminLoginController::class, 'store']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');
    });
});