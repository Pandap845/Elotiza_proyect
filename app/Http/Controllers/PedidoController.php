<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\Elote;
use App\Models\Topping;
use Inertia\Inertia;

class PedidoController extends Controller
{
    /**
     * Mostrar listado de: Carrito, elotes y toppings
     */
    public function index()
    {
        $elotes = Elote::all(); // Cargar elotes con sus toppings
        $toppings = Topping::all();
        return Inertia::render('Compras/Pedido', [
            'elotes' => $elotes,
            'toppings' => $toppings, // También pasar los toppings
            
        ]);
    }

    /**
     * Creación de pedidos
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
