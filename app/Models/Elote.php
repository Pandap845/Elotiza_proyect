<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elote extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'imagen',
        'cantidad'
    ];

    // Relación con DetallePedido
    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }

}
