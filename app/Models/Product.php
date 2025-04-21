<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Define explicitamente o nome da tabela
    protected $table = 'produtos';  // Nome correto da tabela no banco de dados

    // Campos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'name',          // Nome do produto
        'price',         // Preço do produto
        'description',   // Descrição do produto
        'image',         // Caminho da imagem do produto
        'bakery_id',     // Relacionamento com a confeitaria
    ];

    // Relacionamento "pertence a" com a confeitaria
    public function bakery()
    {
        return $this->belongsTo(Bakery::class, 'bakery_id'); // Define que o produto pertence a uma confeitaria
    }

    // Cast para garantir que o preço seja um decimal com 2 casas decimais
    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Atributos de acesso, por exemplo, para formatar o preço de uma maneira customizada
    public function getFormattedPriceAttribute()
    {
        return 'R$ ' . number_format($this->price, 2, ',', '.'); // Exemplo de formatação do preço
    }

    // Você também pode adicionar métodos auxiliares, por exemplo, para trabalhar com imagens
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image); // Retorna a URL completa da imagem armazenada
    }
}
