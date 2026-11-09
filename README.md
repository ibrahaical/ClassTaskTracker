# Class Task Tracker — SchoolTech Indonesia

Aplikasi manajemen tugas kelas berbasis Laravel. Guru dapat mengelola tugas, sedangkan siswa dapat melihat tugas, mencari dan memfilter daftar, serta menandai tugas selesai.

## Teknologi

- **Backend:** Laravel 13, PHP 8.3, dan Laravel Sanctum untuk autentikasi berbasis token
- **Database:** MySQL
- **Frontend:** Blade dan JavaScript dengan Tailwind CSS melalui CDN
- **Pengujian:** PHPUnit

> Tailwind CSS dimuat dari CDN, jadi halaman aplikasi memerlukan koneksi internet untuk memuat stylesheet tersebut.

## Persyaratan

- PHP 8.3 atau lebih baru
- Composer
- MySQL

## Instalasi dan menjalankan aplikasi

1. Clone repositori dan masuk ke direktorinya:

    ```bash
    git clone https://github.com/ibrahaical/ClassTaskTracker.git
    cd ClassTaskTracker
    ```

2. Pasang dependency PHP dan siapkan konfigurasi:

    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    ```

3. Buat database MySQL bernama `class_task_tracker`. Sesuaikan `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`.

4. Jalankan migrasi dan isi data demo:

    ```bash
    php artisan migrate --seed
    ```

    Perintah ini menambahkan data demo ke database yang dikonfigurasi. Untuk database lokal yang boleh dikosongkan dan dibuat ulang, gunakan `php artisan migrate:fresh --seed`.

5. Jalankan server pengembangan:

    ```bash
    php artisan serve
    ```

    Buka `http://127.0.0.1:8000`.

## Akun demo

Seeder membuat satu akun guru dan dua akun siswa. Semua akun demo menggunakan kata sandi `password123`.

| Peran | Email                 |
| ----- | --------------------- |
| Guru  | `guru@schooltech.id`  |
| Siswa | `siswa@schooltech.id` |
| Siswa | `siti@schooltech.id`  |

Form registrasi publik menyediakan pilihan akun siswa atau guru. Akun guru memiliki izin membuat, mengubah, dan menghapus tugas, jadi aktifkan pilihan guru hanya jika pendaftaran guru memang terbuka untuk umum. Ganti kredensial demo sebelum memakai aplikasi di lingkungan nyata.

## Keputusan desain

- Laravel Sanctum menerbitkan Bearer token untuk melindungi endpoint API; password disimpan menggunakan hashing Laravel.
- Role diperiksa pada operasi tugas: guru mengelola tugas, sedangkan siswa hanya dapat melihat tugas dan mengubah status penyelesaiannya.
- Status penyelesaian disimpan terpisah di tabel `task_completions`, dengan batasan unik per pasangan tugas dan siswa agar satu siswa tidak dapat mencatat penyelesaian tugas yang sama berulang kali.
- Status `completed` dan `pending` untuk siswa dihitung berdasarkan penyelesaian milik siswa tersebut. Untuk guru, status berarti sudah atau belum ada siswa yang menyelesaikan tugas.
- Registrasi publik menerima pilihan `teacher` atau `student` sesuai kebutuhan proyek ini. Karena akun guru dapat mengelola tugas, aplikasi nyata sebaiknya membatasi pembuatan akun guru melalui undangan atau persetujuan admin.
- Tailwind CSS dimuat melalui CDN agar tidak memerlukan build frontend saat setup; konsekuensinya, browser perlu koneksi internet.
- Dua nilai tambah yang diprioritaskan adalah feature test endpoint dan tampilan responsif untuk ponsel.

## Belum selesai / pengembangan berikutnya

- Batasi pendaftaran guru dengan kode undangan atau persetujuan admin.
- Terapkan pendaftaran siswa menggunakan kode undangan yang diberikan oleh guru.
- Tambahkan rincian penyelesaian per tugas agar guru dapat melihat siswa yang sudah selesai dan yang belum selesai.
- Notifikasi tugas yang mendekati tenggat belum tersedia.
- Dokumentasi API belum tersedia dalam format OpenAPI/Swagger atau koleksi Postman.

## Endpoint API

Endpoint selain `POST /api/register` dan `POST /api/login` memerlukan token autentikasi pada header `Authorization: Bearer <token>`. Token diperoleh dari endpoint login atau registrasi.

| Method   | Endpoint                           | Akses                                                    |
| -------- | ---------------------------------- | -------------------------------------------------------- |
| `POST`   | `/api/register`                    | Publik; membuat akun siswa atau guru sesuai nilai `role` |
| `POST`   | `/api/login`                       | Publik                                                   |
| `GET`    | `/api/me`                          | Pengguna terautentikasi                                  |
| `POST`   | `/api/logout`                      | Pengguna terautentikasi                                  |
| `GET`    | `/api/tasks?search=&status=&page=` | Guru dan siswa                                           |
| `POST`   | `/api/tasks`                       | Guru                                                     |
| `PUT`    | `/api/tasks/{id}`                  | Guru                                                     |
| `DELETE` | `/api/tasks/{id}`                  | Guru                                                     |
| `PATCH`  | `/api/tasks/{id}/toggle-complete`  | Siswa                                                    |

`search` mencari judul tugas; `status` menerima `completed` atau `pending`; `page` memilih halaman paginasi.

## Pengujian

Jalankan seluruh pengujian dengan:

```bash
php artisan test
```
