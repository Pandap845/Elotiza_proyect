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
        'imagen'
    ];

      // Relación con Elote a través de tabla pivote
      public function elotes()
      {
          return $this->belongsToMany(Elote::class, 'toppings', 'topping_id', 'elote_id');
      }

}
