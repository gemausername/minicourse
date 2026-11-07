<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\InstructorCourseController;
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

    // Manajemen Kursus & Modul Instruktur (FR-08 & FR-09)
    Route::prefix('instructor')->name('instructor.')->group(function () {
        Route::get('/courses', [InstructorCourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/create', [InstructorCourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [InstructorCourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [InstructorCourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [InstructorCourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [InstructorCourseController::class, 'destroy'])->name('courses.destroy');
        Route::get('/courses/{course}/lessons', [InstructorCourseController::class, 'lessons'])->name('courses.lessons');
        Route::post('/courses/{course}/lessons', [InstructorCourseController::class, 'storeLesson'])->name('courses.lessons.store');
        Route::delete('/courses/{course}/lessons/{lesson}', [InstructorCourseController::class, 'destroyLesson'])->name('courses.lessons.destroy');
    });

    // Manajemen Kategori Admin (FR-07)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    });
});
