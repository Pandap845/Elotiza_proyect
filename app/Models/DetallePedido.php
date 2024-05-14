<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'elote_id',
        'topping_id',
        'cantidad',
        'precio'
    ];

    // Relaciones
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function elote()
    {
        return $this->belongsTo(Elote::class);
    }

    public function topping()
    {
        return $this->belongsTo(Topping::class);
    }
}
