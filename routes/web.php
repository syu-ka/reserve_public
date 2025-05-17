<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\Auth\AuthenticatedSessionController as StudentLoginController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Student\ReservationController as StudentReservationController;

// Laravel初期ページ
Route::get('/', function () {
    return view('welcome');
});

// ユーザーダッシュボード（auth: web）
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ユーザー用プロフィールルート
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Laravel Breezeなどの認証ルート
require __DIR__.'/auth.php';


// --------------------
// 生徒用ルート
// --------------------
Route::prefix('student')->name('student.')->group(function () {
    // 未ログイン時のルート
    Route::middleware('guest:student')->group(function () {
        Route::get('login', [StudentLoginController::class, 'create'])->name('login');
        Route::post('login', [StudentLoginController::class, 'store']);
    });

    // ログイン後のルート
    Route::middleware('auth:student')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [StudentLoginController::class, 'destroy'])->name('logout');
        // 予約管理（リソースルート）
        Route::resource('reservations', StudentReservationController::class)->except(['show']);
        
    });
});


// --------------------
// 管理者用ルート
// --------------------
Route::prefix('admin')->name('admin.')->group(function () {
    // 未ログイン時のルート
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminLoginController::class, 'create'])->name('login');
        Route::post('login', [AdminLoginController::class, 'store']);
    });

    // ログイン後のルート
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');

        // 生徒管理（リソースルート）
        Route::resource('students', StudentController::class)->except(['show']);

        // 授業管理（リソースルート）
        Route::resource('lessons', LessonController::class)->except(['show']);

        // 予約管理（リソースルート）
        Route::resource('reservations', AdminReservationController::class)->except(['show']);
        
    });
});
