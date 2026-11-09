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
