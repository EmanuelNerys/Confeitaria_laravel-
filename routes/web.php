<?php

use App\Http\Controllers\BakeryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Página inicial
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de Confeitaria
Route::get('/bakeries', [BakeryController::class, 'index'])->name('bakeries.index'); // Exibe lista de confeitarias
Route::get('/bakeries/create', [BakeryController::class, 'create'])->name('bakeries.create'); // Exibe formulário de criação
Route::post('/bakeries', [BakeryController::class, 'store'])->name('bakeries.store'); // Envia dados para salvar
Route::get('/bakeries/{bakery}/edit', [BakeryController::class, 'edit'])->name('bakeries.edit'); // Exibe formulário de edição
Route::put('/bakeries/{bakery}', [BakeryController::class, 'update'])->name('bakeries.update'); // Atualiza os dados
Route::delete('/bakeries/{bakery}', [BakeryController::class, 'destroy'])->name('bakeries.destroy'); // Exclui confeitaria

// Rotas de perfil do usuário
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
