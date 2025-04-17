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
        $bakeries = Bakery::with('products')->get(); // Carrega as confeitarias com seus produtos
        return Inertia::render('Bakeries/Index', [
            'bakeries' => $bakeries // Envia as confeitarias para o frontend
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
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'cep' => 'required|string|max:10',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        // Cria a nova confeitaria no banco
        Bakery::create($data);

        // Retorna para a lista de confeitarias após salvar
        return redirect()->route('bakeries.index')->with('success', 'Confeitaria cadastrada!');
    }

    // Exibição do formulário de edição de uma confeitaria
    public function edit(Bakery $bakery)
    {
        return Inertia::render('Bakeries/Edit', [
            'bakery' => $bakery // Envia os dados da confeitaria para a página de edição
        ]);
    }

    // Atualização de uma confeitaria existente
    public function update(Request $request, Bakery $bakery)
    {
        // Valida os dados antes de atualizar
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'cep' => 'required|string|max:10',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        // Atualiza a confeitaria com os dados validados
        $bakery->update($data);

        // Retorna para a lista de confeitarias após a atualização
        return redirect()->route('bakeries.index')->with('success', 'Confeitaria atualizada!');
    }

    // Exclusão de uma confeitaria
    public function destroy(Bakery $bakery)
    {
        // Deleta a confeitaria
        $bakery->delete();

        // Retorna para a lista de confeitarias após a exclusão
        return redirect()->route('bakeries.index')->with('success', 'Confeitaria excluída!');
    }
}
