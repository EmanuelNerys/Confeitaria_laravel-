<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * Relacionamento com a bakery.
     */
    public function bakery()
    {
        return $this->belongsTo(Bakery::class); // Cada imagem pertence a uma bakery
    }
}
