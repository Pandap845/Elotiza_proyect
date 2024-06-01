<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasFactory;
    
//----------------------
//Propiedades
//----------------------
    protected $fillable = [
        'nombre',
        'precio',
        'imagen',
        'cantidad'
    ];


    public function carritos()
    {
        return $this->belongsToMany(Carrito::class, 'carrito_topping')->withPivot('cantidad');
    }

    public function detallePedidos()
    {
        return $this->belongsToMany(DetallePedido::class, 'detalle_pedido_topping')->withPivot('cantidad');
    }
    
}
