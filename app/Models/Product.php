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

    // Atributo de acesso para retornar a URL da imagem
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image); // Retorna a URL completa da imagem armazenada
    }

    // Você também pode adicionar validações no modelo para garantir integridade dos dados
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Exemplo de validação antes de criar o produto, você pode personalizar como necessário
            if (empty($product->price)) {
                throw new \Exception('O preço do produto é obrigatório.');
            }
        });
    }
}
