<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bakery extends Model
{
    use HasFactory;

    // Definir explicitamente o nome da tabela, se necessário
    // protected $table = 'bakeries';

    // Campos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'name',         // Nome da confeitaria (alterado para 'name' conforme a tabela)
        'latitude',
        'longitude',
        'postal_code', // ✅ Corrigido aqui
        'street',       // Alterado para 'street', já que você tem esse campo na tabela
        'number',       // Número do local
        'neighborhood', // Bairro onde está a confeitaria
        'city',         // Cidade
        'state',        // Estado
        'phone',        // Telefone da confeitaria
        'image',        // Caminho da imagem (⚠️ agora incluído!)
    ];

    // Relacionamento: Uma confeitaria pode ter muitos produtos
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relacionamento: Uma confeitaria pode ter muitas imagens
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    // Casts para garantir que latitude e longitude sejam floats
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Função que retorna as confeitarias com seus produtos e imagens.
     * Utiliza Eager Loading para carregar os produtos e imagens associados.
     */
    public static function getBakeriesWithProductsAndImages()
    {
        return self::with(['products', 'images'])->get(); // Carrega produtos e imagens com as confeitarias
    }
}
