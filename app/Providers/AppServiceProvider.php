<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ClientService;
use App\Repositories\ClientRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ----------------------------------------------------
        // REGISTRO DE ARQUITECTURA DE CAPAS (CLIENTES)
        // ----------------------------------------------------

        // Registrar el Repositorio (Clase concreta a la Interfaz)
        $this->app->bind(
            ClientRepository::class, // Cambiado para usar la clase concreta directamente
            ClientRepository::class
        );

        // Registrar el Servicio (Clase concreta a la Interfaz)
        $this->app->bind(
            ClientService::class, // Cambiado para usar la clase concreta directamente
            ClientService::class
        );
        // ----------------------------------------------------
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
