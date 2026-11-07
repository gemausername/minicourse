<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        // Cek jika sudah terdaftar
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            $initialStatus = ($course->price > 0) ? 'pending' : 'active';
            $enrollment = Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'status' => $initialStatus,
            ]);
        }

        if ($enrollment->status === 'pending') {
            return redirect()->route('my.courses')
                ->with('success', 'Pendaftaran berhasil dikirim! Menunggu persetujuan / konfirmasi pembayaran oleh Admin.');
        }

        $firstLesson = $course->lessons()->orderBy('order_number')->first();
        if ($firstLesson) {
            return redirect()->route('lessons.show', [$course->slug, $firstLesson->id])
                ->with('success', 'Berhasil mendaftar kursus! Selamat belajar.');
        }

        return redirect()->route('courses.show', $course->slug)
            ->with('success', 'Berhasil mendaftar kursus!');
    }

    public function myCourses()
    {
        $user = Auth::user();
        $enrollments = $user->enrollments()->with('course.category', 'course.lessons')->latest()->get();

        return view('dashboard.my-courses', compact('enrollments'));
    }
}
