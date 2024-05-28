<?php

use Illuminate\Http\Request;
use App\Http\Controllers\auth\authentification;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['guest', 'api'])->group(function () {
    Route::post('/login', [authentification::class, 'login'])->name('login');
    Route::post('/register', [authentification::class, 'register'])->name('register');
});

Route::middleware(['api', 'auth'])->group(function(){
    Route::get('/logout', [authentification::class, 'logout'])->name('logout');

    // projects routes
    Route::post('/projects/create', [ProjectsController::class, 'createProject'])->name('createProject');
    Route::get('/projects/display/all', [ProjectsController::class, 'displayAllProjects'])->name('displayAllProjects');
    Route::put('/projects/updateProject/{id}', [ProjectsController::class, 'updateProject'])->name('updateProject');
    Route::delete('/projects/deleteProject/{id}', [ProjectsController::class, 'deleteProject'])->name('deleteProject');

    // collaboration's members routes
    Route::post('/collaboration/addMembers', [CollaborationController::class, 'addMembers'])->name('addMembers');

    // tasks routes
    Route::post('/tasks/create', [TasksController::class, 'taskCreate'])->name('taskCreate');
    Route::get('/tasks/diplay/{id}', [TasksController::class, 'displayTasks'])->name('displayTasks');
    Route::get('/tasks/{id}/{type}', [TasksController::class, 'tasksByType'])->name('typeTasks');
    Route::put('/tasks/update/{id}', [TasksController::class, 'updateTask'])->name('updateTask');
    Route::patch('/tasks/updateStatus/{id}', [TasksController::class, 'upadateTaskStatus'])->name('upadateTaskStatus');
    Route::delete('/tasks/delete/{id}', [TasksController::class, 'deleteTasks'])->name('deleteTasks');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
