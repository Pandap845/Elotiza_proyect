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
Use App\Models\EnvioPago;


class PedidoController extends Controller
{
    /**
     * Mostrar listado de: Carrito
     */

     protected $apiContext;

     public function __construct()
     {
       
     }

   
     public function confirmarPedido(Request $request)
     {
         $user_id = Auth::id();
     
         // Log the request data
         \Log::info('Confirmar Pedido Request:', $request->all());
         \Log::info('User ID:', ['user_id' => $user_id]);
     
         DB::transaction(function () use ($user_id, $request) {
             // Crear un nuevo pedido
             $pedido = Pedido::create([
                 'user_id' => $user_id,
                 'total' => 0, // Calcular el total más adelante
                 'estado' => 'pendiente',
             ]);
     
             \Log::info('Pedido Created:', $pedido->toArray());
     
             // Mover ítems del carrito a detalle_pedidos
             $carritos = Carrito::with('toppings')->where('user_id', $user_id)->get();
             $total = 0;
     
             foreach ($carritos as $carrito) {
                 $elote = Elote::find($carrito->elote_id);
                 if ($elote->cantidad < $carrito->cantidad) {
                     throw new \Exception('No hay suficientes elotes en stock.');
                 }
                 $elote->cantidad -= $carrito->cantidad;
                 $elote->save();
     
                 $precio_elote = $elote->precio;
                 $precio_total_elote = $precio_elote * $carrito->cantidad;
     
                 $detallePedido = DetallePedido::create([
                     'pedido_id' => $pedido->id,
                     'elote_id' => $carrito->elote_id,
                     'cantidad' => $carrito->cantidad,
                     'precio' => $precio_total_elote,
                 ]);
     
                 \Log::info('Detalle Pedido Created:', $detallePedido->toArray());
     
                 $total += $detallePedido->precio;
     
                 foreach ($carrito->toppings as $topping) {
                     $toppingModel = Topping::find($topping->id);
                     if ($toppingModel->cantidad < $topping->pivot->cantidad) {
                         throw new \Exception('No hay suficientes toppings en stock.');
                     }
                     $toppingModel->cantidad -= $topping->pivot->cantidad;
                     $toppingModel->save();
     
                     $precio_topping = $topping->pivot->precio * $topping->pivot->cantidad;
                     $detallePedido->toppings()->attach($topping->id, [
                         'cantidad' => $topping->pivot->cantidad,
                         'precio' => $precio_topping,
                     ]);
                     \Log::info('Topping Attached:', [
                         'detalle_pedido_id' => $detallePedido->id,
                         'topping_id' => $topping->id,
                         'cantidad' => $topping->pivot->cantidad,
                         'precio' => $precio_topping,
                     ]);
                     $total += $precio_topping;
                 }
     
                 // Eliminar el ítem del carrito
                 $carrito->delete();
                 \Log::info('Carrito Item Deleted:', ['carrito_id' => $carrito->id]);
             }
     
             // Actualizar el total del pedido
             $pedido->update(['total' => $total]);
             \Log::info('Pedido Total Updated:', ['pedido_id' => $pedido->id, 'total' => $total]);
     
             // Crear registro en EnvioPago
             EnvioPago::create([
                 'pedido_id' => $pedido->id,
                 'ciudad' => $request->ciudad,
                 'colonia' => $request->colonia,
                 'calle' => $request->calle,
                 'numero_exterior' => $request->numero_exterior,
                 'numero_interior' => $request->numero_interior,
                 'paypal_id' => $request->paypal_id,
                 
                 'monto' => $total,
             ]);
             \Log::info('Envio realizado');
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
    public function historial()
    {
        $user_id = Auth::id();
        $pedidos = Pedido::with('detallePedidos.toppings', 'detallePedidos.elote')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Compras/Historial', [
            'pedidos' => $pedidos,
        ]);
    }

/**
 * Obtener todos los pedidos que se encuentren en Espera
 * 
 * 
 */

    public function administracion()
    {
        $solicitudesEnEspera = Pedido::with(['detallePedidos.toppings', 'detallePedidos.elote', 'user'])
        ->where('estado', 'pendiente')
        ->orderBy('created_at', 'desc')
        ->get();

    return Inertia::render('Compras/Administracion', [
        'solicitudesEnEspera' => $solicitudesEnEspera,
    ]);
    }

    /**
     * 
     * Obtener la información detallada de los pedidos 
     * 
     */ 

     public function administracionDetalle($id)
     {
         $pedido = Pedido::with(['detallePedidos.toppings', 'detallePedidos.elote', 'user'])
             ->where('id', $id)
             ->firstOrFail();
     
         return Inertia::render('Compras/AdministracionDetalle', [
             'pedido' => $pedido,
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



    

}
