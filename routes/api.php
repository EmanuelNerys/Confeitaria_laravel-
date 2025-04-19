<?php

use App\Http\Controllers\BakeryController;
use App\Http\Controllers\CepController;

// Rota para exibir a lista de confeitarias
Route::get('/bakeries', [BakeryController::class, 'index'])->name('bakeries.index');

// Rota para exibir o formulário de criação de uma confeitaria
Route::get('/bakeries/create', [BakeryController::class, 'create'])->name('bakeries.create');

// Rota para armazenar a nova confeitaria
Route::post('/bakeries', [BakeryController::class, 'store'])->name('bakeries.store');

// Rota para exibir o formulário de edição de uma confeitaria
Route::get('/bakeries/{bakery}/edit', [BakeryController::class, 'edit'])->name('bakeries.edit');

// Rota para atualizar a confeitaria
Route::put('/bakeries/{bakery}', [BakeryController::class, 'update'])->name('bakeries.update');

// Rota para excluir uma confeitaria
Route::delete('/bakeries/{bakery}', [BakeryController::class, 'destroy'])->name('bakeries.destroy');

// Rota para buscar dados do CEP usando a API ViaCEP
Route::get('/buscar-cep/{cep}', [CepController::class, 'buscar'])->name('cep.buscar');

