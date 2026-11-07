<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;

// Katalog Kursus Publik
Route::get('/', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

// Autentikasi (Tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Fitur Pengguna Terautentikasi (Siswa & Instruktur)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Enrollment / Pendaftaran Kursus
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('enroll.store');
    Route::get('/my-courses', [EnrollmentController::class, 'myCourses'])->name('my.courses');

    // Ruang Belajar (Classroom / Video Player)
    Route::get('/courses/{slug}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
});
