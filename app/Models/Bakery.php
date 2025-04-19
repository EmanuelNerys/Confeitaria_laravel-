<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bakery extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'nome',        // Alterei de 'name' para 'nome'
        'latitude',
        'longitude',
        'cep',
        'rua',         // Alterei de 'street' para 'rua'
        'numero',      // Alterei de 'number' para 'numero'
        'bairro',      // Alterei de 'neighborhood' para 'bairro'
        'cidade',      // Alterei de 'city' para 'cidade'
        'estado',      // Alterei de 'state' para 'estado'
        'telefone',    // Alterei de 'phone' para 'telefone'
    ];

    // Relacionamento: Uma confeitaria pode ter muitos produtos
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Casts para garantir que latitude e longitude sejam floats
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
