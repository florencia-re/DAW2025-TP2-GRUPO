<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\ClientRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Contracts\SalesRepositoryInterface;
use App\Repositories\SalesRepository;

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
            ClientRepositoryInterface::class,
            ClientRepository::class
        );

        // Registrar el Repositorio (Clase concreta a la Interfaz)
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            SalesRepositoryInterface::class,
            SalesRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
