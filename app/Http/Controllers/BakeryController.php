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
        return Inertia::render('Index', [
            'bakeries' => Bakery::with('products')->get(),
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
            'postal_code' => 'required|string|max:20',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'neighborhood' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'latitude' => 'nullable|string|max:100',
            'longitude' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
    
        // Redireciona com sucesso
        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria cadastrada com sucesso!']);
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
            
        ]);
    }

    // Método para atualizar os dados de uma confeitaria
    public function update(Request $request, Bakery $bakery)
    {
        // Validação dos dados de atualização
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'postal_code' => 'required|string|max:10', // Corrigido para "postal_code"
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
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
    
        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria atualizada com sucesso!']);
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

        // Redireciona para a listagem com uma mensagem de sucesso
        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria excluída com sucesso!']);
    }
}
