<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; // Model Task
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Menghitung jumlah tugas milik user
        $tasksCount = Task::where('id_user', $user->id)->count();

        // Mengembalikan view dashboard dengan data jumlah tugas
        return view('user.dashboard', compact('tasksCount'));
    }
    public function getAllTask()
    {
        $user = Auth::user();
        $tasks = Task::where('id_user', $user->id)->get();

        return view('user.tasks', [
            'tasks' => $tasks
        ]);
    }

    public function getTaskById($id)
    {
        $task = Task::findOrFail($id);
        $tasks = Task::where('id_user', Auth::id())->get();

        return view('user.tasks', [
            'tasks' => $tasks,
            'editTask' => $task
        ]);
    }

    public function insertTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'required|date',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $task = new Task();
        $task->id_user = Auth::id();
        $task->fill($request->all());
        $task->save();

        return redirect()->route('tasks.index')
            ->with('success', 'Task berhasil dibuat');
    }

    public function updateTask(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $task = Task::findOrFail($id);
        $task->update($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Task berhasil diperbarui');
    }
    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task berhasil dihapus');
    }
}
