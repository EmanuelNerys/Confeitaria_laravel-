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
        $bakeries = Bakery::with('products')->get();

        return Inertia::render('Index', [
            'bakeries' => $bakeries,
            'flash' => session('flash')
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

        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria cadastrada com sucesso!']);
    }

    // Exibição do formulário de edição
    public function edit(Bakery $bakery)
    {
        return Inertia::render('Edit', [
            'bakery' => $bakery
        ]);
    }

    // Atualização de uma confeitaria
    public function update(Request $request, Bakery $bakery)
    {
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

        $bakery->update($data);

        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria atualizada com sucesso!']);
    }

    // Exclusão de uma confeitaria
    public function destroy(Bakery $bakery)
    {
        $bakery->delete();

        return redirect()->route('bakeries.index')->with('flash', ['success' => 'Confeitaria excluída com sucesso!']);
    }
}
