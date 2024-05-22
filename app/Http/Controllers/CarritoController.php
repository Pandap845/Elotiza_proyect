<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Accede a la base de datos para obtener todos los carritos
        $carritos = Carrito::with('elote', 'topping')->get();
        // Retorna la vista con los carritos obtenidos
        return Inertia::render('Carritos/Index', ['carritos' => $carritos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Carritos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida la solicitud
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'elote_id' => 'required|exists:elotes,id',
            'topping_id' => 'required|exists:toppings,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        // Crea un nuevo carrito en la base de datos
        Carrito::create($request->all());

        // Redirige al índice de carritos
        return redirect()->route('carritos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Carrito $carrito)
    {
        // Retorna la vista con el carrito específico
        return Inertia::render('Carritos/Show', ['carrito' => $carrito->load('elote', 'topping')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrito $carrito)
    {
        // Retorna la vista de edición con el carrito específico
        return Inertia::render('Carritos/Edit', ['carrito' => $carrito]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrito $carrito)
    {
        // Valida la solicitud
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'elote_id' => 'required|exists:elotes,id',
            'topping_id' => 'required|exists:toppings,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        // Actualiza el carrito en la base de datos
        $carrito->update($request->all());

        // Redirige al índice de carritos
        return redirect()->route('carritos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrito $carrito)
    {
        // Elimina el carrito de la base de datos
        $carrito->delete();

        // Redirige al índice de carritos
        return redirect()->route('carritos.index');
    }
}
