<?php

namespace App\Http\Controllers;

use App\Models\Elote;
use App\Models\Topping;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EloteController extends Controller
{
    /*Mostrar listado de elotes*/
    public function index()
    {
       
    $elotes = Elote::all(); // Cargar elotes con sus toppings

    return Inertia::render('Elote/Index', [
        'elotes' => $elotes,
        
    ]);
    }


    /*Mostrar listado de elotes y toppings*/
    public function supplies()
    {
        $elotes = Elote::all(); // Cargar elotes con sus toppings
        $toppings = Topping::all();
        return Inertia::render('Supplies', [
            'elotes' => $elotes,
            'toppings' => $toppings, // También pasar los toppings
        ]);
    }

    


    /**
     * Presenta el formulario básico de creación de Elotes
     */
    public function create()
    {
        return Inertia::render('Elotes/Create');
    }

    /**
     * Almacena un recurso en la base de datos
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

        // Crea un nuevo elote en la base de datos
        Elote::create($request->all());

        // Redirige al índice de elotes
        return redirect()->route('supplies');
    }
/**
 * 
 * Mostrar un recurso en específico
 */
    public function show(Elote $elote)
    {
        // Retorna la vista con el elote específico
        return Inertia::render('Elotes/Show', ['elote' => $elote->load('toppings')]);
    }

    /**
     * Mostrar el formulario básico para actualizar un elote
     */
    public function edit(Elote $elote)
    {
        // Retorna la vista de edición con el elote específico
        return Inertia::render('Elotes/Edit', ['elote' => $elote]);
    }



    /**
     * 
     * Actualiza el registro del eelote en la base de datos
     */
    public function update(Request $request, Elote $elote)
    {
        // Valida la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|string',
            'cantidad' => 'nullable|numeric'
        ]);

        // Actualiza el elote en la base de datos
        $elote->update($request->all());

        // Redirige al índice de elotes
        return redirect()->route('supplies');
    }

    /**
     * Elimina el recurso de la base de datos
     */
    public function destroy(Elote $elote)
    {
        // Elimina el elote de la base de datos
        $elote->delete();

        // Redirige al índice de elotes
        return redirect()->route('supplies');
    }
}
