<?php

use App\Http\Controllers\ProductController;
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

// ROTAS DE CONFEITARIAS
Route::prefix('bakeries')->group(function () {
    // Rota para listar todas as confeitarias
    Route::get('/', [BakeryController::class, 'index'])->name('bakeries.index');
    
    // Rota para exibir o formulário de criação de uma nova confeitaria
    Route::get('/create', [BakeryController::class, 'create'])->name('bakeries.create');
    
    // Rota para armazenar os dados da nova confeitaria
    Route::post('/', [BakeryController::class, 'store'])->name('bakeries.store');
    
    // Rota para exibir o formulário de edição de uma confeitaria existente
    Route::get('{bakery}/edit', [BakeryController::class, 'edit'])->name('bakeries.edit');
    
    // Rota para atualizar os dados de uma confeitaria existente
    Route::put('{bakery}', [BakeryController::class, 'update'])->name('bakeries.update');
    
    // Rota para excluir uma confeitaria
    Route::delete('{bakery}', [BakeryController::class, 'destroy'])->name('bakeries.destroy');
    
    // Rota para exibir os detalhes de uma confeitaria
    Route::get('{bakery}/show', [BakeryController::class, 'show'])->name('bakeries.show');
    
    // ROTAS DE PRODUTOS
    Route::prefix('/products')->group(function () {
        // Rota para listar todos os produtos de uma confeitaria
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        
        // Rota para exibir o formulário de criação de um novo produto para uma confeitaria
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        
        // Rota para armazenar um novo produto
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        
        // Rota para exibir o formulário de edição de um produto
        Route::get('{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        
        // Rota para atualizar um produto
        Route::put('{product}', [ProductController::class, 'update'])->name('products.update');
        
        // Rota para excluir um produto
        Route::delete('{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
});










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
