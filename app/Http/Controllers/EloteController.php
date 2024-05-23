<?php

namespace App\Http\Controllers;

use App\Models\Elote;
use App\Models\Topping;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EloteController extends Controller
{
    /**
     * Display a listing of the resource.
     */  /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    $elotes = Elote::all(); // Cargar elotes con sus toppings

    return Inertia::render('Home', [
        'elotes' => $elotes,
        'toppings' => Topping::all(), // También pasar los toppings
    ]);
    }

    public function suministros()
    {
        $elotes = Elote::all(); // Cargar elotes con sus toppings
        $toppings = Topping::all();
        return Inertia::render('PaginaSuministros', [
            'elotes' => $elotes,
            'toppings' => $toppings, // También pasar los toppings
        ]);
    }

    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Elotes/Create');
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

        // Crea un nuevo elote en la base de datos
        Elote::create($request->all());

        // Redirige al índice de elotes
        return redirect()->route('elotes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Elote $elote)
    {
        // Retorna la vista con el elote específico
        return Inertia::render('Elotes/Show', ['elote' => $elote->load('toppings')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Elote $elote)
    {
        // Retorna la vista de edición con el elote específico
        return Inertia::render('Elotes/Edit', ['elote' => $elote]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Elote $elote)
    {
        // Valida la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|string',
        ]);

        // Actualiza el elote en la base de datos
        $elote->update($request->all());

        // Redirige al índice de elotes
        return redirect()->route('elotes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Elote $elote)
    {
        // Elimina el elote de la base de datos
        $elote->delete();

        // Redirige al índice de elotes
        return redirect()->route('elotes.index');
    }
}
