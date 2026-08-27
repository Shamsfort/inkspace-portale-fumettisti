<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RevisorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/fumetti', [ArticleController::class, 'index'])->name('article.index');
Route::get('/fumetti/nuovo/crea', [ArticleController::class, 'create'])->middleware('auth')->name('article.create');
Route::get('/fumetti/{article}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/fumettisti', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/fumettisti/{user}', [ProfileController::class, 'user'])->name('profile.user');
Route::get('/fumettisti/{user}/fumetti', [ArticleController::class, 'byUser'])->name('article.byUser');

Route::get('/contatti', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contatti', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('auth')->group(function () {
    Route::post('/fumetti', [ArticleController::class, 'store'])->name('article.store');
    Route::get('/fumetti/{article}/modifica', [ArticleController::class, 'edit'])->name('article.edit');
    Route::put('/fumetti/{article}', [ArticleController::class, 'update'])->name('article.update');
    Route::delete('/fumetti/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');

    Route::get('/profilo', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profilo/modifica', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profilo', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profilo', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profilo/password', [ProfileController::class, 'editPassword'])->name('profile.editPassword');
    Route::put('/profilo/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    Route::get('/careers', [PublicController::class, 'careers'])->name('careers');
    Route::post('/careers', [PublicController::class, 'carreersSubmit'])->name('careers.submit');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/{user}/set-admin', [AdminController::class, 'setAdmin'])->name('admin.setAdmin');
    Route::patch('/{user}/set-revisor', [AdminController::class, 'setRevisor'])->name('admin.setRevisor');
    Route::patch('/{user}/set-writer', [AdminController::class, 'setWriter'])->name('admin.setWriter');
});

Route::middleware(['auth', 'revisor'])->prefix('revisor')->group(function () {
    Route::get('/dashboard', [RevisorController::class, 'dashboard'])->name('revisor.dashboard');
    Route::post('/{article}/accept', [RevisorController::class, 'accept'])->name('revisor.accept');
    Route::post('/{article}/reject', [RevisorController::class, 'reject'])->name('revisor.reject');
    Route::post('/{article}/undo', [RevisorController::class, 'undo'])->name('revisor.undo');
});
