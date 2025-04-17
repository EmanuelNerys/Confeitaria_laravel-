<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'bakery_id', // Relacionamento com a confeitaria
    ];

    // Relacionamento "pertence a" com a confeitaria
    public function bakery()
    {
        return $this->belongsTo(Bakery::class); // Um produto pertence a uma confeitaria
    }

    // Cast para garantir que o preço seja um decimal com 2 casas decimais
    protected $casts = [
        'price' => 'decimal:2',
    ];
}
