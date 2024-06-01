<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Models\Carrito;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
Use App\Models\Elote;
use App\Models\Topping;

class PedidoController extends Controller
{
    /**
     * Mostrar listado de: Carrito
     */




   
     public function confirmarPedido(Request $request)
     {
         $user_id = Auth::id();
     
         DB::transaction(function () use ($user_id, $request) {
             // Crear un nuevo pedido
             $pedido = Pedido::create([
                 'user_id' => $user_id,
                 'total' => 0, // Calcular el total más adelante
                 'estado' => 'pendiente',
                 'ciudad' => $request->ciudad,
                 'colonia' => $request->colonia,
                 'calle' => $request->calle,
                 'numero_exterior' => $request->numero_exterior,
                 'numero_interior' => $request->numero_interior,
                 'email_paypal' => $request->email_paypal,
                 'paypal_id' => $request->paypal_id,
             ]);
     
             // Mover ítems del carrito a detalle_pedidos
             $carritos = Carrito::with('toppings')->where('user_id', $user_id)->get();
             $total = 0;
     
             foreach ($carritos as $carrito) {
                 $detallePedido = DetallePedido::create([
                     'pedido_id' => $pedido->id,
                     'elote_id' => $carrito->elote_id,
                     'cantidad' => $carrito->cantidad,
                     'precio' => $carrito->cantidad * ($carrito->elote->precio + $carrito->toppings->sum('pivot.precio'))
                 ]);
     
                 $total += $detallePedido->precio;
     
                 foreach ($carrito->toppings as $topping) {
                     $detallePedido->toppings()->attach($topping->id, ['cantidad' => $topping->pivot->cantidad]);
                 }
     
                 // Eliminar el ítem del carrito
                 $carrito->delete();
             }
     
             // Actualizar el total del pedido
             $pedido->update(['total' => $total]);
         });
     
         return Inertia::render('Compras/Pedido'); // Redirigir a la vista de pedidos usando Inertia
     }
     
     public function index()
     {
         $user_id = Auth::id();
         $pedidos = Pedido::with('detallePedidos.toppings')->where('user_id', $user_id)->get();

    
        $user_id = Auth::id();
        \Log::info('User ID:', ['user_id' => $user_id]);

        $carritos = Carrito::with('elote', 'toppings')->where('user_id', $user_id)->get();
        \Log::info('Carritos:', $carritos->toArray());

        $elotes = Elote::all();
        \Log::info('Elotes:', $elotes->toArray());

        $toppings = Topping::all();
        \Log::info('Toppings:', $toppings->toArray());

        foreach ($carritos as $carrito) {
            // Calcular el precio total de los toppings
            $totalToppingsPrice = $carrito->toppings->sum(function ($topping) {
                return $topping->pivot->cantidad * $topping->precio;
            });

            // Calcular el precio total del carrito
            $carrito->precioTotal = ($carrito->elote->precio * $carrito->cantidad) + $totalToppingsPrice;
        }

        return Inertia::render('Compras/Pedido', [
            'carritos' => $carritos,
            'elotes' => $elotes,
            'toppings' => $toppings
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
