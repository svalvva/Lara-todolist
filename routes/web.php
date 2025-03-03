<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Models\Task;

// Routes untuk auth
Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('create.user');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    //Dashboard
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard.index');
    // Task Routes
    Route::get('/tasks', [TaskController::class, 'getAllTask'])->name('tasks.index');
    Route::get('/task/{id}', [TaskController::class, 'getTaskById'])->name('tasks.show');
    Route::post('/task', [TaskController::class, 'insertTask'])->name('tasks.store');
    Route::put('/tasks/{id}', [TaskController::class, 'updateTask'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'deleteTask'])->name('tasks.destroy');

});
