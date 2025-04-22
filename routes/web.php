<?php

use App\Models\Bakery;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BakeryController;
use App\Http\Controllers\ProfileController;

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

// Página HOME
Route::get('/home', function () {
    return Inertia::render('Home', [
        'bakeries' => Bakery::latest()->take(6)->get(),
        'recentProducts' => Product::latest()->take(6)->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'formatted_price' => $product->formatted_price,
                'image' => $product->image,
            ];
        }),
    ]);
})->name('home');

// Rotas de Confeitaria
Route::get('/bakeries', [BakeryController::class, 'index'])->name('bakeries.index');
Route::get('/bakeries/create', [BakeryController::class, 'create'])->name('bakeries.create');
Route::post('/bakeries', [BakeryController::class, 'store'])->name('bakeries.store');
Route::get('/bakeries/{id}/edit', [BakeryController::class, 'edit'])->name('bakeries.edit');
Route::put('/bakeries/{bakery}', [BakeryController::class, 'update'])->name('bakeries.update');
Route::delete('/bakeries/{id}', [BakeryController::class, 'destroy'])->name('bakeries.destroy');

// Rota do mapa 
Route::get('/bakeries/map', [BakeryController::class, 'map'])->name('bakeries.map');


// Nova rota para buscar endereço via CEP
Route::get('/buscar-cep/{cep}', function ($cep) {
    $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

    if ($response->failed() || isset($response->json()['erro'])) {
        return response()->json(['message' => 'CEP não encontrado.'], 404);
    }

    return $response->json();
});

// Rotas de perfil do usuário
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
