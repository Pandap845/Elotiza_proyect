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
        'imagen'
    ];

    // Relación con DetallePedido
    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }

    // Relación con Toppings
    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'toppings', 'elote_id', 'topping_id');
    }
}
