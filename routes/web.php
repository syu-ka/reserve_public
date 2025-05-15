<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonReservationController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/reservations', [LessonReservationController::class, 'index'])->name('reservations.index');
    Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
});

Route::middleware(['auth', 'staff'])->group(function () {
    Route::resource('students', StudentController::class);
});

require __DIR__.'/auth.php';
