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

    
}
