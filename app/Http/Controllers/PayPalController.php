<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use DB;
use App\Models\EnvioPago;
use App\Models\Pedido;
use Auth;
use App\Models\Carrito;
use Inertia\Inertia;
use App\Models\DetallePedido;
use Illuminate\Support\Str;
class PayPalController extends Controller
{
    /**
     * Create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        return response()->json(['message' => 'Transaction created.']);
    }

    /**
     * Process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "MXN",
                        "value" => "1000.00"
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return response()->json(['redirect_url' => $links['href']]);
                }
            }
            return response()->json(['error' => 'Something went wrong.'], 500);
        } else {
            return response()->json(['error' => $response['message'] ?? 'Something went wrong.'], 500);
        }
    }

    /**
     * Success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return response()->json(['success' => 'Transaction complete.', 'paypal_id' => $response['id']]);
        } else {
            return response()->json(['error' => $response['message'] ?? 'Something went wrong.'], 500);
        }
    }

    /**
     * Cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return response()->json(['error' => 'You have canceled the transaction.'], 400);
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
                 $precio_elote = $carrito->elote->precio;
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
                     $precio_topping = $topping->pivot->precio;
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
                
             ]);
         });
     
         return Inertia::render('Compras/Pedido'); // Redirigir a la vista de pedidos usando Inertia
     }


     //Administración

     public function aceptar($id)
     {
         $pedido = Pedido::findOrFail($id);
         $pedido->estado = 'aceptado';
         $pedido->save();
 
         return redirect()->route('administracion');
     }
 
     public function rechazar(Request $request, $id)
{
    try {
        // Encuentra el pedido y actualiza su estado a 'rechazado'
        \Log::info('Iniciando el proceso de rechazo para el pedido: ' . $id);
        $pedido = Pedido::findOrFail($id);
        $envioPago = EnvioPago::where('pedido_id', $id)->firstOrFail();

        // Configura PayPal y obtiene un token de acceso
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        \Log::info('Token de acceso de PayPal obtenido exitosamente.');

        // Realiza la solicitud de reembolso
        \Log::info('Iniciando el proceso de reembolso para el pedido: ' . $id);
        $capture_id = $envioPago->paypal_id;
        $invoice_id = Str::uuid(); // Generar un UUID para el reembolso
        $amount = $envioPago->monto;
        $note_to_payer = 'Reembolso por pedido rechazado';

        $response = $provider->refundCapturedPayment($capture_id, $invoice_id, $amount, $note_to_payer);

        // Registrar la respuesta completa de PayPal
        \Log::info('Respuesta de PayPal: ' . json_encode($response));

        // Verificar que la respuesta contiene el estado esperado
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            \Log::info('Reembolso completado exitosamente para el pedido: ' . $id);
            $pedido->estado = 'rechazado';
            $pedido->save();
            \Log::info('Estado del pedido actualizado a "rechazado" para el pedido: ' . $id);

            
         
          
            \Log::info('ID del reembolso guardado en EnvioPago para el pedido: ' . $id);

            return redirect()->route('administracion')->with('flash', ['status' => 'success', 'message' => 'Reembolso completado con éxito.']);
        } else {
            $errorMessage = isset($response['message']) ? $response['message'] : 'Respuesta inesperada de PayPal';
            \Log::error('Error en el reembolso para el pedido: ' . $id . ' - Mensaje: ' . $errorMessage);
            return redirect()->route('administracion')->with('flash', ['status' => 'error', 'message' => 'Error en el reembolso: ' . $errorMessage]);
        }
    } catch (\Exception $ex) {
        // Maneja excepciones y redirige a la vista de administración con un mensaje de error
        \Log::error('Excepción capturada durante el proceso de reembolso para el pedido: ' . $id . ' - Mensaje: ' . $ex->getMessage());
        return redirect()->route('administracion')->with('flash', ['status' => 'error', 'message' => 'Error en el reembolso: ' . $ex->getMessage()]);
    }
}

     public function cancelar(Request $request, $id)
     {
        
    try {
        // Encuentra el pedido y actualiza su estado a 'rechazado'
        \Log::info('Iniciando el proceso de cancelar para el pedido: ' . $id);
        $pedido = Pedido::findOrFail($id);
        $envioPago = EnvioPago::where('pedido_id', $id)->firstOrFail();

        // Configura PayPal y obtiene un token de acceso
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        \Log::info('Token de acceso de PayPal obtenido: exitosamente.');

        // Realiza la solicitud de reembolso
        \Log::info('Iniciando el proceso de reembolso para el pedido: ' . $id);
        $capture_id = $envioPago->paypal_id;
        $invoice_id = Str::uuid(); // Generar un UUID para el reembolso
        $amount = $envioPago->monto;
        $note_to_payer = 'Reembolso por cancelación';

        $response = $provider->refundCapturedPayment($capture_id, $invoice_id, $amount, $note_to_payer);

        // Registrar la respuesta completa de PayPal
        \Log::info('Respuesta de PayPal: ' . json_encode($response));

        // Verificar que la respuesta contiene el estado esperado
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            \Log::info('Reembolso completado exitosamente para el pedido: ' . $id);
            $pedido->estado = 'cancelado';
            $pedido->save();
            \Log::info('Estado del pedido actualizado a "cancelado" para el pedido: ' . $id);

            
         
            \Log::info('ID del reembolso guardado en EnvioPago para el pedido: ' . $id);

            return redirect()->route('historial')->with('flash', ['status' => 'success', 'message' => 'Reembolso completado con éxito.']);
        } else {
            $errorMessage = isset($response['message']) ? $response['message'] : 'Respuesta inesperada de PayPal';
            \Log::error('Error en el reembolso para el pedido: ' . $id . ' - Mensaje: ' . $errorMessage);
            return redirect()->route('historial')->with('flash', ['status' => 'error', 'message' => 'Error en el reembolso: ' . $errorMessage]);
        }
    } catch (\Exception $ex) {
        // Maneja excepciones y redirige a la vista de administración con un mensaje de error
        \Log::error('Excepción capturada durante el proceso de reembolso para el pedido: ' . $id . ' - Mensaje: ' . $ex->getMessage());
        return redirect()->route('historial')->with('flash', ['status' => 'error', 'message' => 'Error en el reembolso: ' . $ex->getMessage()]);
    }
     }
     
}
