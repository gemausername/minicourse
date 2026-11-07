<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlackBoxSrsTest extends TestCase
{
    use RefreshDatabase;

    // TC-01: Registrasi Akun
    public function test_tc01_registrasi_akun_berhasil()
    {
        $response = $this->post('/register', [
            'name' => 'Budi Siswa Baru',
            'email' => 'budibaru@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'student',
        ]);

        $response->assertRedirect(route('courses.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'budibaru@example.com',
            'name' => 'Budi Siswa Baru',
        ]);
    }

    // TC-02: Login Siswa Kredensial Salah
    public function test_tc02_login_kredensial_salah_ditolak()
    {
        $user = User::factory()->create([
            'email' => 'siswa@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'siswa@example.com',
            'password' => 'passwordsalah',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    // TC-03: Pencarian Kursus
    public function test_tc03_pencarian_kursus()
    {
        $cat = Category::create(['name' => 'Web Dev', 'slug' => 'web-dev']);
        $instructor = User::factory()->create(['role' => 'instructor']);

        Course::create([
            'user_id' => $instructor->id,
            'category_id' => $cat->id,
            'title' => 'Belajar Golang Dasar',
            'slug' => 'belajar-golang-dasar',
            'description' => 'Materi golang',
            'price' => 0,
        ]);

        Course::create([
            'user_id' => $instructor->id,
            'category_id' => $cat->id,
            'title' => 'Belajar Flutter Mobile',
            'slug' => 'belajar-flutter-mobile',
            'description' => 'Materi flutter',
            'price' => 0,
        ]);

        $response = $this->get('/?search=Golang');
        $response->assertStatus(200);
        $response->assertSee('Belajar Golang Dasar');
        $response->assertDontSee('Belajar Flutter Mobile');
    }

    // TC-04: Enrollment Kursus
    public function test_tc04_pendaftaran_kursus_enrollment()
    {
        $student = User::factory()->create(['role' => 'student']);
        $instructor = User::factory()->create(['role' => 'instructor']);
        $cat = Category::create(['name' => 'Data', 'slug' => 'data']);

        $course = Course::create([
            'user_id' => $instructor->id,
            'category_id' => $cat->id,
            'title' => 'Data Analytics Gratis',
            'slug' => 'data-analytics-gratis',
            'description' => 'Materi analisis data',
            'price' => 0,
        ]);

        $response = $this->actingAs($student)->post(route('enroll.store', $course->id));

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active',
        ]);
    }

    // TC-05: Akses Video Materi Tanpa Terdaftar Ditolak
    public function test_tc05_akses_materi_tanpa_enroll_ditolak()
    {
        $student = User::factory()->create(['role' => 'student']);
        $instructor = User::factory()->create(['role' => 'instructor']);
        $cat = Category::create(['name' => 'Design', 'slug' => 'design']);

        $course = Course::create([
            'user_id' => $instructor->id,
            'category_id' => $cat->id,
            'title' => 'UI UX Pro',
            'slug' => 'ui-ux-pro',
            'description' => 'Design course',
            'price' => 50000,
        ]);

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Bab 1 Rahasia Warna',
            'order_number' => 1,
        ]);

        // Siswa belum enroll mencoba akses materi
        $response = $this->actingAs($student)->get(route('lessons.show', [$course->slug, $lesson->id]));

        $response->assertRedirect(route('courses.show', $course->slug));
        $response->assertSessionHas('error');
    }

    // TC-06: Validasi Input Kursus Tanpa Judul Ditolak
    public function test_tc06_input_kursus_tanpa_judul_ditolak()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $cat = Category::create(['name' => 'Web', 'slug' => 'web']);

        $response = $this->actingAs($instructor)->post(route('instructor.courses.store'), [
            'title' => '', // Kosong
            'category_id' => $cat->id,
            'description' => 'Deskripsi ada',
            'price' => 10000,
        ]);

        $response->assertSessionHasErrors('title');
    }
}
