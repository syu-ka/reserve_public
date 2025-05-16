<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\Auth\AuthenticatedSessionController as StudentLoginController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController;

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
    // ログイン（未ログイン時）
    Route::middleware('guest:student')->group(function () {
        Route::get('login', [StudentLoginController::class, 'create'])->name('login');
        Route::post('login', [StudentLoginController::class, 'store']);
    });

    // ダッシュボード・ログアウト（ログイン後）
    Route::middleware('auth:student')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [StudentLoginController::class, 'destroy'])->name('logout');
    });
});


// --------------------
// 管理者用ルート
// --------------------
Route::prefix('admin')->name('admin.')->group(function () {
    // ログイン（未ログイン時）
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminLoginController::class, 'create'])->name('login');
        Route::post('login', [AdminLoginController::class, 'store']);
    });

    // ダッシュボード・ログアウト・管理画面（ログイン後）
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');

        // 生徒管理（リソースルート）
        Route::resource('students', StudentController::class)->except(['show']);
    });
});
