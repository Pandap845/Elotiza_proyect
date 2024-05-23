<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToppingController;
use App\Http\Controllers\EnvioPagoController;
use App\Http\Controllers\EloteController;
use App\Http\Controllers\CarritoController;


use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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


Route::get('/suministros', function () {
    return Inertia::render('PaginaSuministros');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Rutas de los controladores
Route::resource('toppings', ToppingController::class);
Route::get('/api/toppings', [ToppingController::class, 'index']);
Route::get('/api/elotes', [EloteController::class, 'index']);
Route::post('/api/cart/add', [CarritoController::class, 'store']);
//Rutas personalizadas


//Obtener elotes y toppings
//Route::get('/api/elotes', 'EloteController@index');
//Route::get('/api/toppings', 'ToppingController@index');
//Route::post('/api/cart/add', 'CarritoController@agregarAlCarro');

require __DIR__.'/auth.php';