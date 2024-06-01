<?php

namespace App\Http\Controllers;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Elote;
use App\Models\Topping;
use Inertia\Inertia;

use Illuminate\Http\Request;

class SolicitudController extends Controller
{
   // Constructor para aplicar el middleware de autenticación
   public function __construct()
   {
 
   }

   // Método para mostrar la lista de carritos del usuario autenticado
   public function index()
{
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
            return $topping->pivot->cantidad * $topping->pivot->precio;
        });

        // Calcular el precio total del carrito
        $carrito->precioTotal = ($carrito->elote->precio * $carrito->cantidad) + $totalToppingsPrice;
    }

    return Inertia::render('Compras/Solicitud', [
        'carritos' => $carritos,
        'elotes' => $elotes,
        'toppings' => $toppings
    ]);
}
   // Método para mostrar el formulario de creación de un nuevo carrito
   public function create()
   {
       return Inertia::render('Compras/Solicitud');
   }

   // Método para almacenar un nuevo carrito en la base de datos
   public function store(Request $request)
   {
       // Log de la solicitud recibida
       \Log::info('Solicitud recibida para agregar items al carrito', ['request_data' => $request->all()]);
   
       // Validación de la solicitud
       $request->validate([
           'items' => 'required|array',
           'items.*.elote_id' => 'required|exists:elotes,id',
           'items.*.cantidad' => 'required|integer|min:1',
           'items.*.toppings' => 'nullable|array',
           'items.*.toppings.*.id' => 'exists:toppings,id',
           'items.*.toppings.*.cantidad' => 'integer|min:1',
       ]);
   
       $user_id = Auth::id();
       \Log::info('Usuario autenticado', ['user_id' => $user_id]);
   
       foreach ($request->items as $item) {
           $carrito = Carrito::create([
               'user_id' => $user_id,
               'elote_id' => $item['elote_id'],
               'cantidad' => $item['cantidad']
           ]);
   
           \Log::info('Item agregado al carrito', ['carrito_id' => $carrito->id, 'elote_id' => $item['elote_id'], 'cantidad' => $item['cantidad']]);
   
           if (isset($item['toppings'])) {
               foreach ($item['toppings'] as $topping) {
                   $toppingModel = Topping::find($topping['id']);
                   $carrito->toppings()->attach($topping['id'], [
                       'cantidad' => $topping['cantidad'],
                       'precio' => $toppingModel->precio
                   ]);
                   \Log::info('Topping agregado al carrito', [
                       'carrito_id' => $carrito->id,
                       'topping_id' => $topping['id'],
                       'cantidad' => $topping['cantidad'],
                       'precio' => $toppingModel->precio
                   ]);
               }
           }
       }
   
       // Log de finalización del proceso
       \Log::info('Proceso de agregar items al carrito completado', ['user_id' => $user_id]);
   
       return redirect()->route('solicitud.index');
   }
   
   // Método para mostrar un carrito específico
   public function show(Carrito $carrito)
   {
       return Inertia::render('Compras/Solicitud', ['carrito' => $carrito->load('elote', 'topping')]);
   }

   // Método para mostrar el formulario de edición de un carrito
   public function edit(Carrito $carrito)
   {
       return Inertia::render('Compras/Solicitud', ['carrito' => $carrito]);
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

       return redirect()->route('solicitud.index');
   }

   // Método para eliminar un carrito específico de la base de datos
   public function destroy($id)
   {
       $carrito = Carrito::findOrFail($id);
       $carrito->delete();
   
       return redirect()->route('solicitud.index');
   }
}
