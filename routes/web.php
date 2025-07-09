<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CommandeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes d'administration (admin/modérateur uniquement)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Routes pour les utilisateurs
    Route::resource('users', UserController::class);

    // Routes pour les produits
    Route::resource('produits', ProduitController::class);

    // Routes pour les questions
    Route::resource('questions', QuestionController::class);

    // Routes pour les articles
    Route::resource('articles', ArticleController::class);

    // Routes pour les notes
    Route::resource('notes', NoteController::class);

    // Routes pour les commandes
    Route::resource('commandes', CommandeController::class);
});

require __DIR__.'/auth.php';
