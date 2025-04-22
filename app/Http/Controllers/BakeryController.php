<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BakeryController extends Controller
{
    // Exibição da lista de confeitarias
    public function index()
    {
        $flash = session()->get('flash'); // Obtém a sessão flash se ela existir
    
        return Inertia::render('Index', [
            'bakeries' => Bakery::all(),
            'flash' => $flash
        ]);
    }
    
    // Exibição do formulário de criação
    public function create()
    {
        return Inertia::render('Create');
    }

    // Armazenamento da nova confeitaria
    public function store(Request $request)
    {
        // Validação dos campos do formulário
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'cep' => 'required|string|max:10',
            'rua' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação da imagem
        ]);

        // Se houver uma imagem, salva no diretório apropriado
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('bakeries', 'public'); // Salva a imagem na pasta 'public/storage/bakeries'
            $data['image'] = $imagePath; // Adiciona o caminho da imagem no array de dados
        }

        // Cria a confeitaria no banco de dados
        Bakery::create($data);

        // Redireciona para a lista de confeitarias com uma mensagem de sucesso
        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria cadastrada com sucesso!']);
    }

    // Exibição do formulário de edição
    public function edit($id)
{
    $bakery = Bakery::findOrFail($id);

    return Inertia::render('Edit', [
        'bakery' => $bakery
    ]);
    dd($bakery);
}

    

    // Atualização de uma confeitaria
    public function update(Request $request, Bakery $bakery)
    {
        // Validação dos campos do formulário
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'cep' => 'required|string|max:10',
            'rua' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação da imagem
        ]);

        // Se houver uma nova imagem, substitua a imagem antiga
        if ($request->hasFile('image')) {
            // Exclua a imagem anterior, caso exista
            if ($bakery->image) {
                // Verifique se a imagem realmente existe antes de deletá-la
                $oldImagePath = public_path('storage/' . $bakery->image);
                if (file_exists($oldImagePath)) {
                    \Storage::disk('public')->delete($bakery->image); // Apaga a imagem antiga do storage
                }
            }

            // Salva a nova imagem e adiciona o caminho no array de dados
            $imagePath = $request->file('image')->store('bakeries', 'public');
            $data['image'] = $imagePath;
        }

        // Atualiza os dados da confeitaria no banco
        $bakery->update($data);

        // Redireciona para a lista de confeitarias com uma mensagem de sucesso
        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria atualizada com sucesso!']);
    }

    // Exclusão de uma confeitaria
    public function destroy(Bakery $bakery)
    {
        // Exclui a imagem associada à confeitaria, caso exista
        if ($bakery->image) {
            // Verifique se a imagem realmente existe antes de deletá-la
            $imagePath = public_path('storage/' . $bakery->image);
            if (file_exists($imagePath)) {
                \Storage::disk('public')->delete($bakery->image); // Apaga a imagem associada
            }
        }

        // Exclui a confeitaria do banco
        $bakery->delete();

        // Redireciona para a lista de confeitarias com uma mensagem de sucesso
        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria excluída com sucesso!']);
    }
}