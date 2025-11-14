<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;


// Home -> clients
Route::get('/', function () {
    return redirect()->route('clients.index');
});


// Breeze espera "dashboard" despues del login
Route::get('/dashboard', function () {
    return redirect()->route('clients.index');
})->middleware(['auth', 'verified'])->name('dashboard');


// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // CRUD de Usuarios (solo admin, las Policies luego lo restringen)
    Route::resource('users', UserController::class);

    // Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---------------------------------------------
    // CRUD DE CLIENTES CON RUTAS ADICIONALES (Soft Deletes y Ventas Externas)
    // ---------------------------------------------

    Route::resource('clients', ClientController::class)
        ->except(['show'])
        ->middleware(['auth']); // Middleware ya aplicado al grupo, pero se puede duplicar aquí si se desea


    //Muestra la lista de clientes eliminados: GET /clients/archived
    Route::get('clients/archived', [ClientController::class, 'archived'])->name('clients.archived');

    //Ruta para Restaurar un Cliente (Miembro)
    Route::put('clients/restore/{id}', [ClientController::class, 'restore'])
        ->name('clients.restore')
        ->where('id', '[0-9]+'); // Se asegura que {id} es un número

    // Ruta para Ver Ventas Externas
    Route::get('clients/{client}/sales', [ClientController::class, 'sales'])->name('clients.sales');
});

// CRUD de usuarios
Route::resource('users', UserController::class);

Route::get('sales/listSalesByCuit/{cuit}', [SalesController::class, 'listSalesByCuit'])->name('sales.listSalesByCuit');

// Mantiene funcionando rutas de autenticación (login, registro, logout) de Breeze
require __DIR__ . '/auth.php';
