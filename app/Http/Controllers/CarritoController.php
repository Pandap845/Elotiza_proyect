<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use App\Models\Elote;
use App\Models\Topping;

class CarritoController extends Controller
{
    // Constructor para aplicar el middleware de autenticación
    public function __construct()
    {
      // $this->middleware('auth');
    }

    // Método para mostrar la lista de carritos del usuario autenticado
    public function index()
    {
        $elotes = Elote::all(); // Cargar elotes con sus toppings
        $toppings = Topping::all();
        return Inertia::render('Compras/Pedido', [
            'elotes' => $elotes,
            'toppings' => $toppings, // También pasar los toppings
            
        ]);
    }

    // Método para mostrar los pedidos del usuario autenticado
    public function pedido()
    {
        $user_id = Auth::id();
        $carritos = Carrito::with('elote', 'topping')->where('user_id', $user_id)->get();
        $elotes = Elote::all(); // Cargar elotes con sus toppings
        $toppings = Topping::all();
        if ($carritos->isEmpty()) {
            return Inertia::render('Compras/Pedido', [
                'carritos' => [],
                'message' => 'No se encontraron carritos',
                'elotes' => $elotes,
                'toppings' => $toppings
            ]);
        }
    
        return Inertia::render('Compras/Pedido', ['carritos' => $carritos,  'elotes' => $elotes,
        'toppings' => $toppings]);
    }
    
    // Método para mostrar el formulario de creación de un nuevo carrito
    public function create()
    {
        return Inertia::render('Compras/Pedido');
    }

    // Método para almacenar un nuevo carrito en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.elote_id' => 'required|exists:elotes,id',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.topping_id' => 'nullable|exists:toppings,id',
        ]);

        $user_id = Auth::id();
        foreach ($request->items as $item) {
            Carrito::create([
                'user_id' => $user_id,
                'elote_id' => $item['elote_id'],
                'topping_id' => $item['topping_id'] ?? null,
                'cantidad' => $item['cantidad']
            ]);
        }

        return redirect()->route('');
    }

    // Método para mostrar un carrito específico
    public function show(Carrito $carrito)
    {
        return Inertia::render('Carritos/Show', ['carrito' => $carrito->load('elote', 'topping')]);
    }

    // Método para mostrar el formulario de edición de un carrito
    public function edit(Carrito $carrito)
    {
        return Inertia::render('Carritos/Edit', ['carrito' => $carrito]);
    }

    // Método para actualizar un carrito específico en la base de datos
    public function update(Request $request, Carrito $carrito)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'elote_id' => 'required|exists:elotes,id',
            'topping_id' => 'required|exists:toppings,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $carrito->update($request->all());

        return redirect()->route('carritos.index');
    }

    // Método para eliminar un carrito específico de la base de datos
    public function destroy(Carrito $carrito)
    {
        $carrito->delete();

        return redirect()->route('carritos.index');
    }
}
