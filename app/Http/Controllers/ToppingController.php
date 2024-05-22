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
            return Inertia::render('Home', ['toppings' => $toppings]);
        }
    
        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return Inertia::render('Toppings/Create');
        }
    
        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            // Valida la solicitud
            $request->validate([
                'nombre' => 'required|string|max:255',
                'precio' => 'required|numeric',
                'imagen' => 'nullable|string',
            ]);
    
            // Crea un nuevo topping en la base de datos
            Topping::create($request->all());
    
            // Redirige al índice de toppings
            return redirect()->route('toppings.index');
        }
    
        /**
         * Display the specified resource.
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
         * Update the specified resource in storage.
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
            return redirect()->route('toppings.index');
        }
    
        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Topping $topping)
        {
            // Elimina el topping de la base de datos
            $topping->delete();
    
            // Redirige al índice de toppings
            return redirect()->route('toppings.index');
        }
}
