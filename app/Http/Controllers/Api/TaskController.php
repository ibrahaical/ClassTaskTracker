<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskCompletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // GET /api/tasks?search=...&status=completed|pending&page=1
    public function index(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->query(), [
            'search' => 'nullable|string|max:255',
            'status' => 'nullable|in:completed,pending',
            'page' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Parameter pencarian tidak valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status');

        $query = Task::with('creator:id,name')
            ->withCount('completions');

        // Pencarian berdasarkan judul
        if (! empty($search)) {
            $query->where('title', 'like', '%'.$search.'%');
        }

        // Filter berdasarkan status selesai / belum
        if ($status === 'completed') {
            if ($user->role === 'student') {
                $query->whereHas('completions', function ($q) use ($user) {
                    $q->where('student_id', $user->id);
                });
            } else {
                $query->has('completions');
            }
        } elseif ($status === 'pending') {
            if ($user->role === 'student') {
                $query->whereDoesntHave('completions', function ($q) use ($user) {
                    $q->where('student_id', $user->id);
                });
            } else {
                $query->doesntHave('completions');
            }
        }

        $tasks = $query->orderBy('due_date', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(4);

        // Tambahkan atribut is_completed untuk memudahkan tampilan frontend
        $completedTaskIds = [];
        if ($user->role === 'student') {
            $completedTaskIds = TaskCompletion::where('student_id', $user->id)
                ->pluck('task_id')
                ->toArray();
        }

        $tasks->getCollection()->transform(function ($task) use ($user, $completedTaskIds) {
            $task->is_completed = $user->role === 'student'
                ? in_array($task->id, $completedTaskIds)
                : ($task->completions_count > 0);

            return $task;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar tugas berhasil dimuat.',
            'data' => $tasks,
        ], 200);
    }

    // POST /api/tasks (Khusus Guru)
    public function store(Request $request)
    {
        if ($request->user()->role !== 'teacher') {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden: Hanya guru yang boleh membuat tugas.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'class_name' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi input gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $task = Task::create([
            ...$validator->validated(),
            'created_by' => $request->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil dibuat.',
            'data' => $task,
        ], 201);
    }

    // PUT /api/tasks/{id} (Khusus Guru)
    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'teacher') {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden: Siswa tidak diizinkan mengubah tugas.',
            ], 403);
        }

        $task = Task::find($id);
        if (! $task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tugas tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'class_name' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi input gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $task->update($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil diperbarui.',
            'data' => $task,
        ], 200);
    }

    // DELETE /api/tasks/{id} (Khusus Guru)
    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'teacher') {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden: Siswa tidak diizinkan menghapus tugas.',
            ], 403);
        }

        $task = Task::find($id);
        if (! $task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tugas tidak ditemukan.',
            ], 404);
        }

        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil dihapus.',
        ], 200);
    }

    // PATCH /api/tasks/{id}/toggle-complete (Khusus Siswa)
    public function toggleComplete(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role !== 'student') {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden: Hanya siswa yang dapat menandai tugas selesai.',
            ], 403);
        }

        $task = Task::find($id);
        if (! $task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tugas tidak ditemukan.',
            ], 404);
        }

        $existing = TaskCompletion::where('task_id', $task->id)
            ->where('student_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $isCompleted = false;
            $msg = 'Status tugas diubah menjadi belum selesai.';
        } else {
            TaskCompletion::create([
                'task_id' => $task->id,
                'student_id' => $user->id,
                'completed_at' => now(),
            ]);
            $isCompleted = true;
            $msg = 'Tugas berhasil ditandai selesai.';
        }

        return response()->json([
            'status' => 'success',
            'message' => $msg,
            'data' => [
                'task_id' => $task->id,
                'is_completed' => $isCompleted,
            ],
        ], 200);
    }
}
