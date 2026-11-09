<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_receive_token(): void
    {
        $user = User::create([
            'name' => 'Guru Uji',
            'email' => 'guru_uji@schooltech.id',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'data' => ['user', 'token']]);
    }

    public function test_teacher_can_create_task_but_student_is_forbidden(): void
    {
        $teacher = User::create([
            'name' => 'Guru',
            'email' => 'guru@test.id',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);

        $student = User::create([
            'name' => 'Siswa',
            'email' => 'siswa@test.id',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);

        $payload = [
            'title' => 'Tugas Algoritma',
            'description' => 'Kerjakan latihan flowchart',
            'due_date' => now()->addDays(3)->toDateString(),
            'class_name' => 'XII RPL 1',
        ];

        // Guru berhasil membuat tugas (201)
        $this->actingAs($teacher, 'sanctum')
            ->postJson('/api/tasks', $payload)
            ->assertStatus(201);

        // Siswa ditolak saat mencoba membuat tugas (403)
        $this->actingAs($student, 'sanctum')
            ->postJson('/api/tasks', $payload)
            ->assertStatus(403);
    }

    public function test_student_can_toggle_task_completion(): void
    {
        $teacher = User::create([
            'name' => 'Guru',
            'email' => 'guru2@test.id',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);

        $student = User::create([
            'name' => 'Siswa',
            'email' => 'siswa2@test.id',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);

        $task = Task::create([
            'title' => 'Tugas Basis Data',
            'due_date' => now()->addDays(2)->toDateString(),
            'class_name' => 'XII RPL 1',
            'created_by' => $teacher->id,
        ]);

        $this->actingAs($student, 'sanctum')
            ->patchJson("/api/tasks/{$task->id}/toggle-complete")
            ->assertStatus(200)
            ->assertJsonPath('data.is_completed', true);
    }
}
