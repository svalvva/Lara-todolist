<?php

use App\Http\Controllers\Auth\loginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\registerController;


//login
Route::get('/', [loginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [loginController::class, 'login'])->name('login.form');
Route::post('/logout', [loginController::class, 'logout'])->name('logout');

//registration
Route::get('/registration', [registerController::class, 'showRegistrationForm'])->middleware('guest');
Route::post('/registration', [registerController::class, 'register'])->name('create.user');

Route::get('/welcome', function (){
    return view('welcome');
})->middleware('auth');


