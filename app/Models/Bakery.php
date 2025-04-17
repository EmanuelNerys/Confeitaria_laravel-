<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bakery extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'cep',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'phone',
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
