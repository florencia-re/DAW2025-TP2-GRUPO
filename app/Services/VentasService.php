<?php

namespace App\Services;

use App\Repositories\Contracts\SalesRepositoryInterface;
use App\Services\UserService;
use App\Services\ClientService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VentasService
{


    // Inyección de dependencia del servicio
    public function __construct(protected ClientService $clientService, protected UserService $userService, protected SalesRepositoryInterface $salesRepository) {}

    public function listSalesByCuit($clientCuit)
    {

        $listSales = $this->listSales();

        Log::info('Filtrando ventas por CUIT', [
            'cuit_buscado' => $clientCuit,
            'total_ventas' => is_array($listSales) ? count($listSales) : 'no es array',
            'ventas' => $listSales // ← Ver todas las ventas
        ]);

        if (!$listSales) {
            Log::warning('No se pudieron obtener ventas de la API');
            return [];
        }

        $clientSales = array_filter($listSales, function ($sale) use ($clientCuit) {
            Log::debug('Comparando CUIT', [
                'cuitClient' => $sale['cuitClient'] ?? 'NO EXISTE',
                'cuit_buscado' => $clientCuit,
                'match' => isset($sale['cuitClient']) && $sale['cuitClient'] == $clientCuit
            ]);
            return isset($sale['cuitClient']) && $sale['cuitClient'] == $clientCuit;
        });

        Log::info('Ventas filtradas', [
            'total_filtradas' => count($clientSales),
            'ventas_filtradas' => $clientSales
        ]);

        return array_values($clientSales);
    }


    public function listSales()
    {
        if (!$this->isAuthenticated()) {
            Log::warning('Falla en la validación de la API');
            return null;     // Autenticación fallida
        }
        $listSales = $this->salesRepository->getAll(10);

        return $listSales;
    }

    public function isAuthenticated(): bool
    {
        return session('external_api_authenticated', false);
    }
}
