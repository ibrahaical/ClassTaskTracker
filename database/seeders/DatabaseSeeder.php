<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskCompletion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = User::create([
            'name' => 'Budi Santoso (Guru)',
            'email' => 'guru@schooltech.id',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'class_name' => 'XII RPL 1',
        ]);

        $student1 = User::create([
            'name' => 'Andi Pratama (Siswa)',
            'email' => 'siswa@schooltech.id',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'class_name' => 'XII RPL 1',
        ]);

        $student2 = User::create([
            'name' => 'Siti Aminah (Siswa)',
            'email' => 'siti@schooltech.id',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'class_name' => 'XII RPL 1',
        ]);

        $tasks = [
            [
                'title' => 'Merancang ERD Database Perpustakaan',
                'description' => 'Buatlah Entity Relationship Diagram lengkap dengan primary key dan foreign key.',
                'due_date' => now()->addDays(2)->toDateString(),
                'class_name' => 'XII RPL 1',
            ],
            [
                'title' => 'Implementasi REST API Autentikasi JWT/Sanctum',
                'description' => 'Buat endpoint register, login, dan logout beserta hashing password.',
                'due_date' => now()->addDays(4)->toDateString(),
                'class_name' => 'XII RPL 1',
            ],
            [
                'title' => 'Latihan Query JOIN dan Agregasi SQL',
                'description' => 'Kerjakan 5 soal query SQL pada modul praktikum halaman 24.',
                'due_date' => now()->addDays(1)->toDateString(),
                'class_name' => 'XII RPL 1',
            ],
            [
                'title' => 'Code Review & Pencegahan SQL Injection',
                'description' => 'Perbaiki kode PHP raw query menjadi Prepared Statement.',
                'due_date' => now()->addDays(5)->toDateString(),
                'class_name' => 'XII RPL 2',
            ],
            [
                'title' => 'Membuat Halaman Frontend Responsif',
                'description' => 'Pastikan tampilan daftar tugas nyaman dibuka di layar HP maupun desktop.',
                'due_date' => now()->addDays(7)->toDateString(),
                'class_name' => 'XII RPL 1',
            ],
            [
                'title' => 'Menulis Dokumentasi README Proyek',
                'description' => 'Sertakan langkah instalasi, akun demo, dan daftar endpoint API.',
                'due_date' => now()->addDays(10)->toDateString(),
                'class_name' => 'XII RPL 1',
            ],
        ];

        foreach ($tasks as $index => $t) {
            $createdTask = Task::create(array_merge($t, ['created_by' => $teacher->id]));
            // Tandai 2 tugas pertama sudah selesai oleh siswa1 sebagai contoh
            if ($index < 2) {
                TaskCompletion::create([
                    'task_id' => $createdTask->id,
                    'student_id' => $student1->id,
                    'completed_at' => now(),
                ]);
            }
        }
    }
}
