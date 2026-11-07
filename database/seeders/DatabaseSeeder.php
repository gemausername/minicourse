<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Instruktur & Siswa
        $instructor = User::create([
            'name' => 'Budi Instruktur',
            'email' => 'instruktur@example.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
        ]);

        $student = User::create([
            'name' => 'Andi Siswa',
            'email' => 'siswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // 2. Kategori Kursus
        $catWeb = Category::create(['name' => 'Web Development', 'slug' => 'web-development']);
        $catDesign = Category::create(['name' => 'UI/UX Design', 'slug' => 'ui-ux-design']);
        $catData = Category::create(['name' => 'Data Science', 'slug' => 'data-science']);

        // 3. Kursus Contoh
        $course1 = Course::create([
            'user_id' => $instructor->id,
            'category_id' => $catWeb->id,
            'title' => 'Mastering Laravel 12 dari Dasar sampai Mahir',
            'slug' => 'mastering-laravel-12',
            'description' => 'Pelajari framework PHP terpopuler di dunia mulai dari MVC, Routing, Database, hingga REST API.',
            'price' => 150000,
            'thumbnail' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80',
        ]);

        $course2 = Course::create([
            'user_id' => $instructor->id,
            'category_id' => $catDesign->id,
            'title' => 'Desain Antarmuka Modern dengan Figma',
            'slug' => 'desain-antarmuka-modern-figma',
            'description' => 'Kuasai teknik wireframing, prototyping, dan design system untuk membangun aplikasi web profesional.',
            'price' => 99000,
            'thumbnail' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=600&q=80',
        ]);

        $course3 = Course::create([
            'user_id' => $instructor->id,
            'category_id' => $catWeb->id,
            'title' => 'Belajar HTML, CSS, dan JavaScript Pemula',
            'slug' => 'belajar-html-css-javascript',
            'description' => 'Panduan lengkap belajar coding web gratis untuk pemula tanpa pengalaman sebelumnya.',
            'price' => 0, // Gratis
            'thumbnail' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80',
        ]);

        // 4. Materi / Silabus (Lessons)
        Lesson::create([
            'course_id' => $course1->id,
            'title' => 'Pengenalan Laravel & Konsep MVC',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'content' => 'Selamat datang di modul 1. Di sesi ini kita akan membahas dasar arsitektur MVC pada Laravel.',
            'order_number' => 1,
        ]);

        Lesson::create([
            'course_id' => $course1->id,
            'title' => 'Routing dan Controller Sederhana',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'content' => 'Di modul 2 ini kita belajar bagaimana menghubungkan URL ke Controller untuk menampilkan halaman.',
            'order_number' => 2,
        ]);

        Lesson::create([
            'course_id' => $course2->id,
            'title' => 'Mengenal Toolbar & Frame Figma',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'content' => 'Langkah awal membuat project di Figma serta trik navigasi kanvas.',
            'order_number' => 1,
        ]);

        // 5. Sample Enrollment (Siswa sudah daftar course 1)
        Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $course1->id,
            'status' => 'active',
        ]);
    }
}
