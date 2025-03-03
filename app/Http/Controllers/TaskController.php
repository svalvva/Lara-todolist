<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; // Model Task
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function getAllTask()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mengambil semua task milik user
        $tasks = Task::where('id_user', $user->id)->get();

        if ($tasks->isEmpty()) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'status' => 'error',
                'message' => 'Data task tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'status' => 'success',
            'data' => $tasks,
        ], 200);
    }

    public function getTaskById(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_task' => 'required|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'success' => false,
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Mengambil task berdasarkan ID
        $task = Task::find($request->id_task);

        return response()->json([
            'code' => 200,
            'success' => true,
            'status' => 'success',
            'data' => $task,
        ], 200);
    }

    public function insertTask(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'success' => false,
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Membuat task baru
        $task = new Task();
        $task->judul = $request->judul;
        $task->deskripsi = $request->deskripsi;
        $task->deadline = $request->deadline;
        $task->status = $request->status;
        $task->id_user = $user->id;

        if (!$task->save()) {
            return response()->json([
                'code' => 500,
                'success' => false,
                'status' => 'error',
                'message' => 'Gagal menyimpan task',
            ], 500);
        }

        return response()->json([
            'code' => 201,
            'success' => true,
            'status' => 'success',
            'message' => 'Task berhasil disimpan',
            'data' => $task,
        ], 201);
    }

    public function updateTask(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_task' => 'required|exists:tasks,id',
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'status' => 'nullable|in:pending,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'success' => false,
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Mengambil task berdasarkan ID
        $task = Task::find($request->id_task);

        // Memperbarui data task
        if ($request->has('judul')) {
            $task->judul = $request->judul;
        }
        if ($request->has('deskripsi')) {
            $task->deskripsi = $request->deskripsi;
        }
        if ($request->has('deadline')) {
            $task->deadline = $request->deadline;
        }
        if ($request->has('status')) {
            $task->status = $request->status;
        }

        if (!$task->save()) {
            return response()->json([
                'code' => 500,
                'success' => false,
                'status' => 'error',
                'message' => 'Gagal memperbarui task',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'status' => 'success',
            'message' => 'Task berhasil diperbarui',
            'data' => $task,
        ], 200);
    }

    public function deleteTask(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_task' => 'required|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'success' => false,
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Mengambil task berdasarkan ID
        $task = Task::find($request->id_task);

        // Menghapus task
        if (!$task->delete()) {
            return response()->json([
                'code' => 500,
                'success' => false,
                'status' => 'error',
                'message' => 'Gagal menghapus task',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'status' => 'success',
            'message' => 'Task berhasil dihapus',
            'deleted_id' => $task->id,
        ], 200);
    }
}