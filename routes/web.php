<?php

use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToppingController;
use App\Http\Controllers\EnvioPagoController;
use App\Http\Controllers\EloteController;
use App\Http\Controllers\CarritoController;


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


//-----------------------------
// Rutas de los controladores

//-------------------
// Toppings
Route::resource('toppings', ToppingController::class); //CRUD


//----------------------
// Elotes
Route::resource('elotes', EloteController::class); //CRUD

//----------------------
// pedidos y envíos
Route::resource('pedidos', PedidoController::class); //CRUD
Route::resource('detalles', DetallePedidoController::class); //CRUD
Route::resource('envios', EnvioPagoController::class); //CRUD


//------------------------
//Carrito
Route::resource('carritos', CarritoController::class); //CRUD






//-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.
//---------------------------
//Rutas de páginas

//Suministros
Route::get('/supplies', [EloteController::class, 'supplies'])->name('supplies');

//Compras y carrito


Route::get('/pedido', [PedidoController::class,'index'])->name('pedido');



//------------------------
require __DIR__.'/auth.php';
