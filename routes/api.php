<?php

use App\Http\Controllers\API\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/approve/role/{role}', [ProjectController::class, 'index'])->name('approve.index');
Route::get('/approve/completed', [ProjectController::class, 'completed'])->name('approve.completed');
Route::get('/approve/trashed', [ProjectController::class, 'trashed'])->name('approve.trashed');
Route::get('/approve/project/create', [ProjectController::class, 'create'])->name('approve.project.create');
Route::post('/approve/project/store', [ProjectController::class, 'store'])->name('approve.project.store');
Route::post('/approve/update/{id}', [ProjectController::class, 'update'])->name('approve.update');
Route::post('/approve/restore/{id}', [ProjectController::class, 'restore'])->name('approve.restore');
Route::post('/approve/unapproved/{id}', [ProjectController::class, 'unapproved'])->name('approve.unapproved');
Route::delete('/approve/delete/{id}', [ProjectController::class, 'destroy'])->name('approve.delete');
Route::delete('/approve/forceDelete/{id}', [ProjectController::class, 'forceDelete'])->name('approve.forceDelete');
