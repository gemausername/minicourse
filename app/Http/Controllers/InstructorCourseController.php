<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InstructorCourseController extends Controller
{
    // Hanya bisa diakses oleh role instructor atau admin
    private function checkAccess()
    {
        $role = Auth::user()->role ?? '';
        if ($role !== 'instructor' && $role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini khusus Instruktur / Admin.');
        }
    }

    public function index()
    {
        $this->checkAccess();
        $courses = Course::with(['category', 'lessons', 'enrollments'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('instructor.courses.index', compact('courses'));
    }

    public function create()
    {
        $this->checkAccess();
        $categories = Category::all();
        return view('instructor.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|url',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Course::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $course = Course::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'thumbnail' => $validated['thumbnail'] ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80',
        ]);

        return redirect()->route('instructor.courses.lessons', $course->id)
            ->with('success', 'Kursus berhasil dibuat! Sekarang silakan tambahkan modul materinya.');
    }

    public function edit(Course $course)
    {
        $this->checkAccess();
        if ($course->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $categories = Category::all();
        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $this->checkAccess();
        if ($course->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|url',
        ]);

        $course->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'thumbnail' => $validated['thumbnail'] ?: $course->thumbnail,
        ]);

        return redirect()->route('instructor.courses.index')
            ->with('success', 'Kursus berhasil diperbarui!');
    }

    public function destroy(Course $course)
    {
        $this->checkAccess();
        if ($course->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $course->delete();
        return redirect()->route('instructor.courses.index')
            ->with('success', 'Kursus berhasil dihapus.');
    }

    // Manajemen Modul Pembelajaran (Lessons)
    public function lessons(Course $course)
    {
        $this->checkAccess();
        if ($course->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $course->load('lessons');
        return view('instructor.courses.lessons', compact('course'));
    }

    public function storeLesson(Request $request, Course $course)
    {
        $this->checkAccess();
        if ($course->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'content' => 'nullable|string',
            'order_number' => 'nullable|integer|min:1',
        ]);

        $order = $validated['order_number'] ?? ($course->lessons()->max('order_number') + 1);

        Lesson::create([
            'course_id' => $course->id,
            'title' => $validated['title'],
            'video_url' => $validated['video_url'],
            'content' => $validated['content'],
            'order_number' => $order,
        ]);

        return redirect()->route('instructor.courses.lessons', $course->id)
            ->with('success', 'Modul materi baru berhasil ditambahkan!');
    }

    public function destroyLesson(Course $course, Lesson $lesson)
    {
        $this->checkAccess();
        if ($course->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $lesson->delete();
        return redirect()->route('instructor.courses.lessons', $course->id)
            ->with('success', 'Modul materi berhasil dihapus.');
    }
}
