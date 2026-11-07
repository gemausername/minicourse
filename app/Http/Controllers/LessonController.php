<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show($courseSlug, $lessonId)
    {
        $course = Course::with(['lessons'])->where('slug', $courseSlug)->firstOrFail();
        $user = Auth::user();

        // Verifikasi apakah user sudah terdaftar di kursus ini
        $isEnrolled = $user->enrollments()->where('course_id', $course->id)->exists();
        if (!$isEnrolled && $user->role !== 'instructor' && $user->role !== 'admin') {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Anda harus mendaftar kursus ini terlebih dahulu untuk mengakses materi.');
        }

        $lesson = Lesson::where('course_id', $course->id)->findOrFail($lessonId);

        return view('lessons.show', compact('course', 'lesson'));
    }
}
