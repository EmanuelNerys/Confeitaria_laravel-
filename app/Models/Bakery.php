<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bakery extends Model
{
    use HasFactory;

    // Definir explicitamente o nome da tabela caso seja diferente
    // protected $table = 'bakeries';  // Se o nome da tabela for diferente, defina aqui.

    // Campos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'nome',        // Nome da confeitaria
        'latitude',
        'longitude',
        'cep',
        'rua',         // Rua onde está a confeitaria
        'numero',      // Número do local
        'bairro',      // Bairro onde está a confeitaria
        'cidade',      // Cidade
        'estado',      // Estado
        'telefone',    // Telefone da confeitaria
    ];

    // Relacionamento: Uma confeitaria pode ter muitos produtos
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relacionamento: Uma confeitaria pode ter muitas imagens
    public function images()
    {
        return $this->hasMany(Image::class); // Uma bakery pode ter muitas imagens
    }

    // Casts para garantir que latitude e longitude sejam floats
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Função que retorna as confeitarias com seus produtos e imagens.
     * Utiliza Eager Loading para carregar os produtos e imagens associados.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getBakeriesWithProductsAndImages()
    {
        return self::with(['products', 'images'])->get(); // Eager loading para carregar os produtos e imagens junto
    }
}
