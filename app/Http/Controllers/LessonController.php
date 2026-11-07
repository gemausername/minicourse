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

        // Verifikasi apakah user sudah terdaftar dan aktif di kursus ini
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        $isInstructorOrAdmin = in_array($user->role, ['instructor', 'admin']);

        if (!$isInstructorOrAdmin) {
            if (!$enrollment) {
                return redirect()->route('courses.show', $course->slug)
                    ->with('error', 'Anda harus mendaftar kursus ini terlebih dahulu untuk mengakses materi.');
            }
            if ($enrollment->status !== 'active') {
                return redirect()->route('my.courses')
                    ->with('error', 'Pendaftaran Anda sedang berstatus pending, menunggu persetujuan admin.');
            }
        }

        $lesson = Lesson::where('course_id', $course->id)->findOrFail($lessonId);

        return view('lessons.show', compact('course', 'lesson'));
    }
}
