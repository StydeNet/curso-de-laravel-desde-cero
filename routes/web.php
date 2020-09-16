<?php

use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
   return view('welcome');
});

// Users
Route::get('/usuarios', [UserController::class, 'index'])
    ->name('users.index');

Route::get('/usuarios/{user}', [UserController::class, 'show'])
    ->where('user', '[0-9]+')
    ->name('users.show');

Route::get('/usuarios/nuevo', [UserController::class, 'create'])->name('users.create');

Route::post('/usuarios', [UserController::class, 'store']);

Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');

Route::put('/usuarios/{user}', [UserController::class, 'update']);

Route::get('/usuarios/papelera', [UserController::class, 'index'])->name('users.trashed');

Route::patch('/usuarios/{user}/papelera', [UserController::class, 'trash'])->name('users.trash');

Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Profile
Route::get('/editar-perfil/', [ProfileController::class, 'edit']);

Route::put('/editar-perfil/', [ProfileController::class, 'update']);

// Professions
Route::get('/profesiones/', [ProfessionController::class, 'index']);

Route::delete('/profesiones/{profession}', [ProfessionController::class, 'destroy']);

// Skills
Route::get('/habilidades/', [SkillController::class, 'index']);
