<?php

namespace App\Http\Controllers;

use App\Models\Topping;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ToppingController extends Controller
    {
         /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Accede a la base de datos para obtener todos los toppings
        $toppings = Topping::all();
        // Retorna la vista con los toppings obtenidos
        return Inertia::render('Toppings/Index', ['toppings' => $toppings]);
    }

    /**
     *
     */
    public function create()
    {
        return Inertia::render('Toppings/Create');
    }

    /**
     *Almacena un topping recien creado
     */
    public function store(Request $request)
    {
        // Valida la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|string',
            'cantidad' => 'required|numeric'
        ]);

        // Crea un nuevo topping en la base de datos
        Topping::create($request->all());
        // Redirige al índice de toppings
        return redirect()->route('supplies');
    }

    /**
     * Muestra los toppings existentes
     */
    public function show(Topping $topping)
    {
        // Retorna la vista con el topping específico
        return Inertia::render('Toppings/Show', ['topping' => $topping]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topping $topping)
    {
        // Retorna la vista de edición con el topping específico
        return Inertia::render('Toppings/Edit', ['topping' => $topping]);
    }

    /**
     * Actualiza un topping en la base de datos
     */
    public function update(Request $request, Topping $topping)
    {
        // Valida la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|string',
        ]);

        // Actualiza el topping en la base de datos
        $topping->update($request->all());

        // Redirige al índice de toppings
        return redirect()->route('supplies');
    }

    /**
     * Elimina un topping de la BD
     */
    public function destroy(Topping $topping)
    {
        // Elimina el topping de la base de datos
        $topping->delete();

        // Redirige al índice de toppings
        return redirect()->route('supplies');
    }
}
