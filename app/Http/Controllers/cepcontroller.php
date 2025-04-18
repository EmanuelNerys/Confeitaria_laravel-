<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CepController extends Controller
{
    // Método que busca o endereço a partir do CEP
    public function buscar($cep)
    {
        // Remove qualquer caractere não numérico do CEP
        $cep = preg_replace('/\D/', '', $cep);

        // Verifica se o CEP possui 8 dígitos
        if (strlen($cep) !== 8) {
            return response()->json(['error' => 'CEP inválido'], 400);
        }

        // Faz a requisição à API do ViaCEP
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        // Se a resposta falhar ou o CEP não for encontrado
        if ($response->failed() || $response->json('erro')) {
            return response()->json(['error' => 'CEP não encontrado'], 404);
        }

        // Retorna os dados do CEP
        return response()->json($response->json());
    }
}
