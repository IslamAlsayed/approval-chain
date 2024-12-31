<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => view('welcome'));

Route::get('/approve/role/{role}', [ProjectController::class, 'index'])->name('approve.index');
Route::get('/approve/completed', [ProjectController::class, 'completed'])->name('approve.completed');
Route::get('/approve/trashed', [ProjectController::class, 'trashed'])->name('approve.trashed');

Route::get('/approve/project/create', [ProjectController::class, 'create'])->name('approve.project.create');
Route::post('/approve/project/store', [ProjectController::class, 'store'])->name('approve.project.store');

Route::get('/approve/admin/create', [AdminController::class, 'create'])->name('approve.admin.create');
Route::post('/approve/admin/store', [AdminController::class, 'store'])->name('approve.admin.store');

Route::put('/approve/restore/{id}', [ProjectController::class, 'restore'])->name('approve.restore');
Route::put('/approve/update/{id}', [ProjectController::class, 'update'])->name('approve.update');
Route::put('/approve/unapproved/{id}', [ProjectController::class, 'unapproved'])->name('approve.unapproved');
Route::delete('/approve/delete/{id}', [ProjectController::class, 'destroy'])->name('approve.delete');
Route::delete('/approve/forceDelete/{id}', [ProjectController::class, 'forceDelete'])->name('approve.forceDelete');
