# Mini Udemy Clone - Platform Kursus Online Berbasis Web

> Sistem Manajemen Pembelajaran (LMS) sederhana yang dibangun dengan framework **Laravel 12/13**, basis data **SQLite**, dan antarmuka modern **Tailwind CSS**. Dikembangkan mengikuti acuan dokumen spesifikasi **SRS (Software Requirements Specification)** dengan metodologi SDLC Waterfall.

---

## 👥 Tim Pengembang
Proyek ini dikembangkan secara kolaboratif oleh tim beranggotakan 3 orang dengan pembagian modul:
1. **Anggota 1:** Modul Autentikasi Pengguna & Role Siswa/Instruktur (`FR-01`, `FR-02`).
2. **Anggota 2:** Modul Katalog Kursus, Detail Silabus & Ruang Belajar (`FR-03`, `FR-04`, `FR-06`).
3. **Anggota 3:** Modul Manajemen Kursus, Kategori & Validasi Pendaftaran Siswa (`FR-05`, `FR-07`, `FR-08`, `FR-09`, `FR-10`).

---

## 🎯 Fitur Sistem (Kesesuaian dengan Dokumen SRS)

| Kode SRS | Nama Fitur | Deskripsi | Hak Akses | Status |
| :---: | :--- | :--- | :---: | :---: |
| **FR-01** | Registrasi Akun | Pendaftaran akun baru dengan memilih role (Siswa / Instruktur). | Publik | ✅ Selesai |
| **FR-02** | Login & Logout | Autentikasi sesi aman menggunakan email & password. | Publik / User | ✅ Selesai |
| **FR-03** | Katalog Kursus | Pencarian kursus dan filter berdasarkan kategori topik. | Publik | ✅ Selesai |
| **FR-04** | Detail Kursus | Rincian materi, kurikulum silabus, profil instruktur, dan harga. | Publik | ✅ Selesai |
| **FR-05** | Enrollment Kursus | Pendaftaran kursus (Otomatis Aktif jika gratis / Pending jika berbayar). | Siswa | ✅ Selesai |
| **FR-06** | Ruang Belajar | Player pemutar video materi (embed) + rangkuman catatan bab. | Siswa Terdaftar | ✅ Selesai |
| **FR-07** | Kelola Kategori | Tambah, ubah, dan hapus kategori topik pembelajaran. | Admin / Instruktur | ✅ Selesai |
| **FR-08** | Kelola Kursus | Buat kursus baru, edit judul/deskripsi/harga/thumbnail, dan hapus. | Admin / Instruktur | ✅ Selesai |
| **FR-09** | Kelola Modul Materi | Unggah video materi dan susun urutan bab materi silabus. | Admin / Instruktur | ✅ Selesai |
| **FR-10** | Validasi Pendaftaran | Pantau dan setujui (approve) pendaftaran siswa yang berstatus pending. | Admin / Instruktur | ✅ Selesai |

---

## 🚀 Panduan Menjalankan di Komputer Lokal

### 1. Kloning Repository
```bash
git clone git@github.com:gemausername/minicourse.git
cd minicourse
```

### 2. Pasang Dependensi
```bash
composer install
```

### 3. Konfigurasi Environment & Key
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database SQLite & Seeder
```bash
touch database/database.sqlite
php artisan migrate:fresh --seed
```

### 5. Jalankan Web Server
```bash
php artisan serve
```
Akses aplikasi melalui peramban web di: **`http://127.0.0.1:8000`**

---

## 🔑 Akun Demo Siap Pakai

| Peran (Role) | Email | Kata Sandi | Kegunaan |
| :--- | :--- | :--- | :--- |
| **Siswa (Student)** | `siswa@example.com` | `password` | Menguji alur pencarian, enroll kursus, dashboard, dan menonton materi. |
| **Instruktur / Admin** | `instruktur@example.com` | `password` | Menguji buat kursus baru, tambah modul video, kategori, dan approval siswa. |

---

## 🧪 Pengujian Black Box Testing (Bab 4 SRS)
Sistem telah dilengkapi dengan automated feature test yang menguji secara langsung setiap skenario pengujian di dokumen SRS (`TC-01` s/d `TC-06`).

Untuk menjalankan seluruh uji otomatis:
```bash
php artisan test --filter=BlackBoxSrsTest
```
Semua 6 skenario pengujian akan tervalidasi dengan hasil **PASSED**.

---

## 🌐 Panduan Deployment ke Server Mobian (`gemas.v6.rocks`)

Karena sistem menggunakan **SQLite** dan **PHP native**, deployment di server Mobian (Debian ARM/SBC) sangat ringan dan hemat memori (< 150 MB RAM total):

1. **Masuk ke Server Mobian:**
   ```bash
   ssh mobian@gemas.v6.rocks
   ```

2. **Kloning ke Direktori Web Server:**
   ```bash
   git clone git@github.com:gemausername/minicourse.git /var/www/minicourse
   cd /var/www/minicourse
   ```

3. **Install & Setup:**
   ```bash
   composer install --no-dev --optimize-autoloader
   cp .env.example .env
   php artisan key:generate
   touch database/database.sqlite
   php artisan migrate --force --seed
   sudo chown -R www-data:www-data storage bootstrap/cache database
   ```

4. **Konfigurasi Web Server (Nginx):**
   Arahkan root direktori ke `/var/www/minicourse/public`.
