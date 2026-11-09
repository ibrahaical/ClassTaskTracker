# Class Task Tracker — SchoolTech Indonesia

Aplikasi **Manajemen Tugas Kelas (Class Task Tracker)** berbasis Fullstack Web & REST API. Guru dapat mengelola tugas kelas (CRUD), sementara siswa dapat melihat daftar tugas, mencari/memfilter tugas, serta menandai tugas sebagai selesai.

## Tech Stack

- **Backend:** Laravel (PHP) + Laravel Sanctum (Bearer Token Authentication)
- **Database:** MySQL (Migrations & Seeder)
- **Frontend:** Blade + Vanilla JavaScript (`fetch` API) + Tailwind CSS (Responsive Mobile & Desktop)
- **Automated Testing:** PHPUnit Feature Test

_(Catatan Penggunaan AI: AI digunakan sebagai referensi penyusunan struktur boilerplate komponen UI dan kerangka dokumentasi README. Seluruh logika bisnis controller, validasi otorisasi role guru/siswa, skema relasi database, dan pengujian endpoint diperiksa serta disesuaikan secara mandiri)._

---

## Cara Menjalankan Aplikasi dari Nol (Langkah demi Langkah)

1. **Clone repositori ini:**
    ```bash
    git clone [https://github.com/username-anda/class-task-tracker.git](https://github.com/username-anda/class-task-tracker.git)
    cd class-task-tracker
    ```

2. **Pasang dependency dan siapkan konfigurasi:**
    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    ```
    Buat database MySQL `class_task_tracker`, lalu sesuaikan `DB_*` di `.env`.

3. **Jalankan migrasi dan data contoh:**
    ```bash
    php artisan migrate:fresh --seed
    ```
    Akun demo: `guru@schooltech.id` dan `siswa@schooltech.id`, keduanya memakai password `password123`.

Pendaftaran publik hanya membuat akun siswa. Akun guru dibuat lewat seeder atau proses administrasi tepercaya.

## Endpoint API

- `POST /api/register`, `POST /api/login`, `GET /api/me`, `POST /api/logout`
- `GET /api/tasks?search=&status=&page=`
- `POST /api/tasks`, `PUT /api/tasks/{id}`, `DELETE /api/tasks/{id}` (guru)
- `PATCH /api/tasks/{id}/toggle-complete` (siswa)

Jalankan pengujian dengan `php artisan test`.
