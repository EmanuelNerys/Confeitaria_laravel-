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
        // Recupera todas as confeitarias com seus produtos associados
        $bakeries = Bakery::with('products')->get();

        // Retorna os dados para a página Vue.js via Inertia, incluindo a mensagem flash
        return Inertia::render('Bakeries/Index', [
            'bakeries' => $bakeries,
            'flash' => session('flash') // Passando flash de sessão, caso haja
        ]);
    }

    // Exibição do formulário de criação
    public function create()
    {
        return Inertia::render('Bakeries/Create'); // Renderiza a página de criação
    }

    // Armazenamento da nova confeitaria
    public function store(Request $request)
    {
        // Valida os dados antes de salvar no banco
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
        ]);

        Bakery::create($data);

        // Redireciona para a página de listagem com mensagem de sucesso
        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria cadastrada com sucesso!']);
    }

    // Exibição do formulário de edição
    public function edit(Bakery $bakery)
    {
        return Inertia::render('Bakeries/Edit', [
            'bakery' => $bakery
        ]);
    }

    // Atualização de uma confeitaria
    public function update(Request $request, Bakery $bakery)
    {
        // Validação dos dados para atualização
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
        ]);

        // Atualiza a confeitaria com os novos dados
        $bakery->update($data);

        // Redireciona para a página de listagem com mensagem de sucesso
        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria atualizada com sucesso!']);
    }

    // Exclusão de uma confeitaria
    public function destroy(Bakery $bakery)
    {
        $bakery->delete();

        // Redireciona para a página de listagem com mensagem de sucesso
        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria excluída com sucesso!']);
    }
}

