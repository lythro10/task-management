<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });



Route::get('/', [ProjectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// We redirect the dashboard route to the ProjectController index method
Route::get('/dashboard', [ProjectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
// Route for adding a new task to a project
Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');

// Tasks update and delete routes
Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Project Create route
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
