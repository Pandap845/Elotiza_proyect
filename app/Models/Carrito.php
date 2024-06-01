<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    // Define la tabla asociada al modelo
    protected $table = 'carritos';

    // Define los campos que pueden ser asignados masivamente
    protected $fillable = [
        'user_id',
        'elote_id',
        'cantidad'
    ];

    // Define la relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define la relación con el modelo Elote
    public function elote()
    {
        return $this->belongsTo(Elote::class);
    }

//Define la relación con el modelo Topping
public function toppings()
{
    return $this->belongsToMany(Topping::class, 'carrito_topping')
        ->withPivot('cantidad', 'precio');
}

}