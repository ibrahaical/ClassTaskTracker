<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskCompletion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_login_to_receive_a_bearer_token(): void
    {
        $this->postJson('/api/register', [
            'name' => 'Calon Guru',
            'email' => 'guru-baru@schooltech.id',
            'password' => 'password123',
            'role' => 'teacher',
        ])->assertUnprocessable()
            ->assertJsonStructure(['status', 'message', 'errors']);

        $this->assertDatabaseMissing('users', ['email' => 'guru-baru@schooltech.id']);

        $registration = $this->postJson('/api/register', [
            'name' => 'Siswa Baru',
            'email' => '  Student@SchoolTech.ID ',
            'password' => 'password123',
            'class_name' => 'XII RPL 1',
        ]);

        $registration->assertCreated()
            ->assertJsonStructure(['status', 'message', 'data' => ['user', 'token']])
            ->assertJsonPath('data.user.email', 'student@schooltech.id')
            ->assertJsonPath('data.user.role', 'student');

        $user = User::where('email', 'student@schooltech.id')->firstOrFail();
        $this->assertTrue(Hash::check('password123', $user->password));

        $this->postJson('/api/login', [
            'email' => ' STUDENT@SCHOOLTECH.ID ',
            'password' => 'password123',
        ])->assertOk()
            ->assertJsonStructure(['status', 'message', 'data' => ['user', 'token']])
            ->assertJsonPath('data.user.role', 'student');
    }

    public function test_unauthenticated_user_receives_consistent_401_json(): void
    {
        $this->getJson('/api/tasks')
            ->assertUnauthorized()
            ->assertExactJson([
                'status' => 'error',
                'message' => 'Unauthenticated. Silakan login terlebih dahulu.',
            ]);
    }

    public function test_teacher_can_create_update_and_delete_a_task(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $this->actingAs($teacher, 'sanctum');

        $payload = [
            'title' => 'Tugas Algoritma',
            'description' => 'Kerjakan latihan flowchart',
            'due_date' => now()->addDays(3)->toDateString(),
            'class_name' => 'XII RPL 1',
        ];

        $created = $this->postJson('/api/tasks', $payload)
            ->assertCreated()
            ->assertJsonStructure(['status', 'message', 'data' => ['id', 'title']])
            ->assertJsonPath('data.title', 'Tugas Algoritma');

        $taskId = $created->json('data.id');

        $this->putJson("/api/tasks/{$taskId}", [
            ...$payload,
            'title' => 'Tugas Algoritma Diperbarui',
        ])->assertOk()
            ->assertJsonPath('data.title', 'Tugas Algoritma Diperbarui');

        $this->deleteJson("/api/tasks/{$taskId}")
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $this->assertDatabaseMissing('tasks', ['id' => $taskId]);
    }

    public function test_student_cannot_create_update_or_delete_tasks(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $task = $this->createTask($teacher, 'Tugas yang Dilindungi');
        $this->actingAs($student, 'sanctum');

        $payload = [
            'title' => 'Tugas Baru',
            'description' => null,
            'due_date' => now()->addDays(2)->toDateString(),
            'class_name' => 'XII RPL 1',
        ];

        $this->postJson('/api/tasks', $payload)->assertForbidden();
        $this->putJson("/api/tasks/{$task->id}", $payload)->assertForbidden();
        $this->deleteJson("/api/tasks/{$task->id}")->assertForbidden();

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Tugas yang Dilindungi']);
    }

    public function test_student_can_search_filter_paginate_and_toggle_task_completion(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $completedTask = $this->createTask($teacher, 'Aljabar Dasar');
        $pendingTask = $this->createTask($teacher, 'Aljabar Lanjutan');
        TaskCompletion::create([
            'task_id' => $completedTask->id,
            'student_id' => $student->id,
            'completed_at' => now(),
        ]);

        foreach (range(1, 5) as $number) {
            $this->createTask($teacher, "Tugas Tambahan {$number}");
        }

        $this->actingAs($student, 'sanctum');

        $this->getJson('/api/tasks?search=%20Aljabar%20&status=completed')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.id', $completedTask->id)
            ->assertJsonPath('data.data.0.is_completed', true);

        $this->getJson('/api/tasks?search=Aljabar&status=pending')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.id', $pendingTask->id)
            ->assertJsonPath('data.data.0.is_completed', false);

        $this->actingAs($teacher, 'sanctum');
        $this->getJson('/api/tasks?search=Aljabar&status=completed')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.id', $completedTask->id);

        $this->getJson('/api/tasks?search=Aljabar&status=pending')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.id', $pendingTask->id);

        $this->actingAs($student, 'sanctum');
        $this->patchJson("/api/tasks/{$pendingTask->id}/toggle-complete")
            ->assertOk()
            ->assertJsonPath('data.is_completed', true);

        $this->getJson('/api/tasks?search=Aljabar&status=completed')
            ->assertOk()
            ->assertJsonPath('data.total', 2);

        $this->getJson('/api/tasks?page=2')
            ->assertOk()
            ->assertJsonPath('data.current_page', 2)
            ->assertJsonPath('data.last_page', 2);
    }

    public function test_invalid_task_filter_and_missing_api_route_use_consistent_errors(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $this->actingAs($student, 'sanctum');

        $this->getJson('/api/tasks?status=unknown')
            ->assertUnprocessable()
            ->assertJsonStructure(['status', 'message', 'errors']);

        $this->getJson('/api/does-not-exist')
            ->assertNotFound()
            ->assertJsonStructure(['status', 'message']);
    }

    private function createTask(User $teacher, string $title): Task
    {
        return Task::create([
            'title' => $title,
            'description' => null,
            'due_date' => now()->addDays(2)->toDateString(),
            'class_name' => 'XII RPL 1',
            'created_by' => $teacher->id,
        ]);
    }
}
