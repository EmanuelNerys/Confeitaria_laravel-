<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BakeryController extends Controller
{
    // Método para listar todas as confeitarias com seus produtos relacionados
    public function index()
    {
        // Carregar as confeitarias com seus produtos
        $bakeries = Bakery::with('products')->get();
    
        // Passar o resultado correto para o Inertia
        return Inertia::render('ListaConfeitaria', [
            'bakeries' => $bakeries, // Passando a variável correta
        ]);
    }
    

    // Método para exibir o formulário de criação de uma nova confeitaria
    public function create()
    {
        return Inertia::render('Create'); // Aqui você retorna a view "Create", onde o formulário estará
    }

    // Método para salvar uma nova confeitaria
    public function store(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|string|max:100',
            'longitude' => 'nullable|string|max:100',
            'number' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);
    
        $data = $validated;
    
        // Se houver imagem, faz upload
        if ($request->hasFile('image')) {
            if (!$request->file('image')->isValid()) {
                return redirect()->back()->with('flash', ['error' => 'Imagem inválida.']);
            }
    
            $imagePath = $request->file('image')->store('bakeries', 'public');
            $data['image'] = $imagePath;
        }
    
        // Cria a confeitaria
        Bakery::create($data);
    
        return response()->json(['success' => true]);
    }

    // Método para exibir o formulário de edição
    public function edit($id)
    {
        $bakery = Bakery::findOrFail($id);
        return Inertia::render('Edit', [
            'bakery' => $bakery
        ]);
    }

    // Método para mostrar os detalhes de uma confeitaria
    public function show($id)
    {
        $bakery = Bakery::findOrFail($id);
        return Inertia::render('Show', [
            'bakery' => $bakery,
            'products' => $bakery->products,
        ]);
    }

    // Método para atualizar os dados de uma confeitaria
    public function update(Request $request, Bakery $bakery)
    {
        // Validação dos dados de atualização
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'latitude' => 'nullable|string|max:100',
            'longitude' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Atualiza os dados da confeitaria
        $bakery->update($data);
    
        // Verifica e atualiza a imagem, se necessário
        if ($request->hasFile('image')) {
            if ($bakery->image) {
                $oldImagePath = public_path('storage/' . $bakery->image);
                if (file_exists($oldImagePath)) {
                    \Storage::disk('public')->delete($bakery->image);
                }
            }
    
            $imagePath = $request->file('image')->store('bakeries', 'public');
            $bakery->image = $imagePath;
            $bakery->save();
        }
    
        return response()->json(['message' => 'Cadastrado com sucesso']);
    }

    // Método para excluir uma confeitaria
    public function destroy(Bakery $bakery)
    {
        // Exclui a imagem, se existir
        if ($bakery->image) {
            $imagePath = public_path('storage/' . $bakery->image);
            if (file_exists($imagePath)) {
                \Storage::disk('public')->delete($bakery->image);
            }
        }

        // Exclui a confeitaria do banco de dados
        $bakery->delete();

        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria excluída com sucesso!']);
    }
}
