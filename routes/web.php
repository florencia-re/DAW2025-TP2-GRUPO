<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProfileController; 


// Home -> clients
Route::get('/', function () {
    return redirect()->route('clients.index');
});


//breeze espera "dashboard" despues del login
Route::get('/dashboard', function () {
    return redirect()->route('clients.index');
})->middleware(['auth', 'verified'])->name('dashboard');


//rutas protegidas
Route::middleware(['auth'])->group(function () {
    // CRUD de Usuarios (solo admin, las Policies luego lo restringen)
    Route::resource('users', UserController::class);
    // CRUD de Clientes
    Route::resource('clients', ClientController::class);
    // Ver ventas de un cliente (servicio externo)
    Route::get('clients/{client}/sales', [SalesController::class, 'show'])
         ->name('clients.sales.show');

    //Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Mantiene funcionando rutas de autenticación (login, registro, logout) de Breeze
require __DIR__.'/auth.php';
