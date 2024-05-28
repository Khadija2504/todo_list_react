<?php

use App\Http\Controllers\auth\authentification;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    Route::post('/login', [authentification::class, 'login'])->name('login');
    Route::post('/register', [authentification::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function(){
    Route::get('/logout', [authentification::class, 'logout'])->name('logout');

    // projects routes
    Route::post('/projects/create', [ProjectsController::class, 'createProject'])->name('craeteProject');
    Route::get('/projects/display/all', [ProjectsController::class, 'displayAllProjects'])->name('displayAllProjects');

    // collaboration's members routes
    Route::post('/collaboration/addMembers', [CollaborationController::class, 'addMembers'])->name('addMembers');

    // tasks routes
    Route::post('/tasks/create', [TasksController::class, 'createTask'])->name('createTask');
    Route::get('/tasks/diplay', [TasksController::class, 'displayTasks'])->name('displayTasks');
});