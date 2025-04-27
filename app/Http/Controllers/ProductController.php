<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Exibe os produtos de uma confeitaria.
     *
     * @param  Bakery  $bakery
     * @return \Inertia\Response
     */
    public function index(Bakery $bakery)
    {
        // Garantir que a confeitaria existe e carregar os produtos relacionados
        $bakery->load('products'); 
    
        // Retornar os dados para a view usando Inertia
        return Inertia::render('Products/Index', [
            'bakery' => $bakery, // Passa a confeitaria com os produtos
            'flash' => session('flash'), // Flash messages, caso existam
        ]);
    }

    // Método para mostrar os detalhes de uma confeitaria
    public function show($id)
    {
        $bakery = Bakery::findOrFail($id);
        return Inertia::render('Show', [
            'products' => $bakery->products,
        ]);
    }

    /**
     * Exibe o formulário de criação de um novo produto.
     *
     * @param  Bakery  $bakery
     * @return \Inertia\Response
     */
    public function create()
    {
       return Inertia::render('Create'); // Aqui você retorna a view "Create", onde o formulário estará
    }

    /**
     * Armazena um novo produto no banco de dados.
     *
     * @param  Request  $request
     * @param  Bakery  $bakery
     * @return \Inertia\Response
     */
    public function store(Request $request, Bakery $bakery)
    {
        // Validação dos dados do formulário
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'bakery_id' => 'required|exists: bakeries,id', // Verifica se a confeitaria existe
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validação da imagem
        ]);

        
        try {
            // Criar um novo produto associado à confeitaria
            if ($request->hasFile('image')) {
                // Se tiver imagem, fazer upload
                $imagePath = $request->file('image')->store('products', 'public');
                $validatedData['image'] = $imagePath;
            }

            $product = $bakery->products()->create($validatedData);

            // Mensagem de sucesso
            session()->flash('flash.success', 'Produto criado com sucesso!');

            // Redirecionar para a página de produtos da confeitaria
            return redirect()->route('home')->with('flash', ['success' => 'Confeitaria produt com sucesso!']);
        } catch (\Exception $e) {
            // Tratar qualquer erro inesperado
            session()->flash('flash.error', 'Erro ao criar produto: ' . $e->getMessage());
            return redirect()->route('products.index', $bakery);
        }
    }

    /**
     * Exibe o formulário de edição de um produto.
     *
     * @param  Bakery  $bakery
     * @param  Product  $product
     * @return \Inertia\Response
     */
    public function edit(Bakery $bakery, Product $product)
    {
        // Garantir que o produto pertence à mesma confeitaria
        if ($product->bakery_id !== $bakery->id) {
            abort(404); // Caso o produto não pertença à confeitaria
        }

        return Inertia::render('ProductEdit', [
            'bakery' => $bakery, 
            'product' => $product,
            'flash' => session('flash'), // Flash messages
        ]);
    }

    /**
     * Atualiza um produto no banco de dados.
     *
     * @param  Request  $request
     * @param  Bakery  $bakery
     * @param  Product  $product
     * @return \Inertia\Response
     */
    public function update(Request $request, Bakery $bakery, Product $product)
    {
        // Garantir que o produto pertence à mesma confeitaria
        if ($product->bakery_id !== $bakery->id) {
            abort(404); // Caso o produto não pertença à confeitaria
        }

        // Validação dos dados do formulário
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            // Atualizando os dados do produto
            if ($request->hasFile('image')) {
                // Se houver nova imagem, fazer o upload e salvar o caminho
                $imagePath = $request->file('image')->store('products', 'public');
                $validatedData['image'] = $imagePath;
            }

            $product->update($validatedData);

            // Mensagem de sucesso
            session()->flash('flash.success', 'Produto atualizado com sucesso!');

            // Redirecionar para a página de produtos da confeitaria
            return redirect()->route('products.index', $bakery);
        } catch (\Exception $e) {
            // Tratar qualquer erro inesperado
            session()->flash('flash.error', 'Erro ao atualizar produto: ' . $e->getMessage());
            return redirect()->route('products.index', $bakery);
        }
    }

    /**
     * Exclui um produto do banco de dados.
     *
     * @param  Bakery  $bakery
     * @param  Product  $product
     * @return \Inertia\Response
     */
    public function deactivate(Bakery $bakery, Product $product)
    {
        try {
            // Garantir que o produto pertence à mesma confeitaria
            if ($product->bakery_id !== $bakery->id) {
                // Caso o produto não pertença à confeitaria, redireciona com erro
                session()->flash('flash.error', 'Produto não encontrado na confeitaria.');
                return redirect()->route('products.index', $bakery);
            }
    
            // Verificar se o produto já está desativado
            if ($product->is_active) {
                // Alterar o status do produto para inativo
                $product->is_active = false;
                $product->save();
    
                // Mensagem de sucesso
                session()->flash('flash.success', 'Produto desativado com sucesso!');
            } else {
                // Caso o produto já esteja desativado
                session()->flash('flash.info', 'Produto já está desativado.');
            }
    
            // Redirecionar para a página de produtos da confeitaria
            return redirect()->route('products.index', $bakery);
    
        } catch (\Exception $e) {
            // Tratar erros inesperados
            session()->flash('flash.error', 'Erro ao desativar produto: ' . $e->getMessage());
            return redirect()->route('products.index', $bakery);
        }
    }
}    
    


