<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;

// Routes untuk auth
Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    //Task
    Route::get('/tasks', [TaskController::class, 'getAllTask']);
    Route::get('/task/{id}', [TaskController::class, 'getTaskById']);
    Route::post('/task', [TaskController::class, 'insertTask']);
    Route::put('/task', [TaskController::class, 'updateTask']);
    Route::delete('/task', [TaskController::class, 'deleteTask']);
});



