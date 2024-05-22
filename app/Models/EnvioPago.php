<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioPago extends Model
{
    use HasFactory;

    // Define la tabla asociada al modelo
    protected $table = 'envio_pagos';

    // Define los campos que pueden ser asignados masivamente
    protected $fillable = [
        'pedido_id',
        'ciudad',
        'colonia',
        'calle',
        'numero_exterior',
        'numero_interior',
        'metodo_pago',
        'email_paypal',
        'paypal_id',
        'monto',
        'estado'
    ];

    // Define la relación con el modelo Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}