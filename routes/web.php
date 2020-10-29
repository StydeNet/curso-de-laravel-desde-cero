<?php

use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
   return view('welcome');
});

// Users
Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

Route::get('/users/{user}', [UserController::class, 'show'])
    ->where('user', '[0-9]+')
    ->name('users.show');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

Route::post('/users', [UserController::class, 'store']);

Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

Route::put('/users/{user}', [UserController::class, 'update']);

Route::get('/users/trash', [UserController::class, 'index'])->name('users.trashed');

Route::patch('/users/{user}/trash', [UserController::class, 'trash'])->name('users.trash');

Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Profile
Route::get('/edit-profile/', [ProfileController::class, 'edit']);

Route::put('/edit-profile/', [ProfileController::class, 'update']);

// Professions
Route::get('/professions/', [ProfessionController::class, 'index']);

Route::delete('/professions/{profession}', [ProfessionController::class, 'destroy']);

// Skills
Route::get('/skills/', [SkillController::class, 'index']);

Route::get('wrong', function () {
    throw new \Exception('wrong');
});
