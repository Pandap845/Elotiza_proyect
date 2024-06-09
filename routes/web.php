<?php

use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ToppingController;
use App\Http\Controllers\EnvioPagoController;
use App\Http\Controllers\EloteController;

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PayPalController;


use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use PayPal\Api\Patch;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



//Rutas de las páginas
Route::get('/home', function () {
    return Inertia::render('Home');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//-----------------------------administracion
// Rutas de los controladores

//-------------------
// Toppings
Route::resource('toppings', ToppingController::class); //CRUD


//----------------------
// Elotes
Route::resource('elotes', EloteController::class); //CRUD

//----------------------
// pedidos y envíos

Route::middleware('auth')->group(function () {
    Route::resource('solicitud', SolicitudController::class);
  
    Route::resource('pedidos', PedidoController::class); //CRUD
Route::resource('detalles', DetallePedidoController::class); //CRUD
Route::resource('envios', EnvioPagoController::class); //CRUD
Route::post('/confirmar-pedido', [PedidoController::class, 'confirmarPedido'])->name('confirmarPedido');
Route::get('/pedido', [PayPalController::class, 'createTransaction'])->name('createTransaction');
Route::post('/paypal/process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('/paypal/success', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('/paypal/cancel', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
Route::get('/historial', [PedidoController::class, 'historial'])->name('historial');
Route::post('/pago/confirmar', [PayPalController::class, 'confirmarPago'])->name('confirmarPago');
Route::get('/administracion', [PedidoController::class, 'administracion'])->name('administracion');
Route::get('/administracion/detalle/{id}', [PedidoController::class, 'administracionDetalle'])->name('administracion.detalle');
Route::put('/paypal/aceptar/{id}', [PayPalController::class, 'aceptar'])->name('paypal.aceptar');
Route::put('/paypal/rechazar/{id}', [PayPalController::class, 'rechazar'])->name('paypal.rechazar');
Route::put('/paypal/cancelar/{id}', [PayPalController::class, 'cancelar'])->name('paypal.cancelar');

Route::post('/pedido/reembolsar', [PedidoController::class, 'reembolsar'])->name('pedido.reembolsar');

});
//------------------------

//-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.
//---------------------------
//Rutas de páginas

//Suministros
Route::get('/supplies', [EloteController::class, 'supplies'])->name('supplies');

//Compras y carrito





//------------------------
require __DIR__.'/auth.php';
