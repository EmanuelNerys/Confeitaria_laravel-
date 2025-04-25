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
// Grupo de rotas para CONFEITARIAS
Route::prefix('bakeries')->group(function () {
    
    // 🧁 Listar todas as confeitarias
   // Route::get('/', [BakeryController::class, 'index'])->name('bakeries.index');

   Route::get('/listaconfeitaria', function () {
    return Inertia::render('ListaConfeitaria', [
        'bakeries' => Bakery::with('products')->latest()->take(6)->get(),
        'recentProducts' => Product::latest()->take(6)->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'formatted_price' => $product->formatted_price, // Certifique-se de que existe no Product
                'image' => $product->image ? asset('storage/products/' . $product->image) : null,
            ];
        }),
        'flash' => [
            'success' => session('success'),
            'error' => session('error'),
        ],
    ]);
})->name('bakeries.index');

// 🆕 Exibir formulário de criação de confeitaria
    Route::get('/create', [BakeryController::class, 'create'])->name('bakeries.create');
    
    // 💾 Armazenar nova confeitaria (formulário POST)
    Route::post('/store', [BakeryController::class, 'store'])->name('bakeries.store');
    
    // ✏️ Exibir formulário de edição de uma confeitaria específica
    Route::get('{bakery}/edit', [BakeryController::class, 'edit'])->name('bakeries.edit');
    
    // 🔁 Atualizar dados de uma confeitaria
    Route::put('{bakery}', [BakeryController::class, 'update'])->name('bakeries.update');
    
    // 🗑️ Deletar uma confeitaria
    Route::delete('{bakery}', [BakeryController::class, 'destroy'])->name('bakeries.destroy');
    
    // 👁️ Ver detalhes de uma confeitaria
    Route::get('{bakery}/show', [BakeryController::class, 'show'])->name('bakeries.show');

    // 📦 Listar produtos de uma confeitaria específica
    Route::get('/{id}/products', [ProductController::class, 'show'])->name('bakeries.products.show');
    
    // Subgrupo de rotas para PRODUTOS
    Route::prefix('/products')->group(function () {

        // 🆕 Exibir formulário de criação de produto
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');

        // 💾 Armazenar novo produto
        Route::post('/', [ProductController::class, 'store'])->name('products.store');

        // ✏️ Exibir formulário de edição de produto
        Route::get('{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

        // 🔁 Atualizar um produto
        Route::put('{product}', [ProductController::class, 'update'])->name('products.update');

        // 🗑️ Deletar um produto
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
