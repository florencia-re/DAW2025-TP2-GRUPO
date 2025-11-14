<?php

namespace App\Services;

use App\Repositories\Contracts\SalesRepositoryInterface;
use App\Services\UserService;
use App\Services\ClientService;
use Illuminate\Support\Facades\Http;

class VentasService
{


    // Inyección de dependencia del servicio
    public function __construct(protected ClientService $clientService, protected UserService $userService, protected SalesRepositoryInterface $salesRepository) {}

    public function listSalesByCuit($token, $clientCuit)
    {

        $listSales = $this->listSales($token, $clientCuit);

        $clientSales = array_filter($listSales, function ($sale) use ($clientCuit) {
            return $sale['cuit_client'] == $clientCuit;  // Ajusta según estructura
        });

        return $clientSales;
    }


    public function listSales($token)
    {
        $token = $this->validateApiCall($token);

        if (!$token) {
            return null; // Autenticación fallida
        }
        $listSales = $this->salesRepository->getAll(10, $token);

        return $listSales;
    }

    public function validateApiCall($token)
    {
        $response = Http::post('http://localhost/daw2025/TP/Public/login', [
            'token' => $token
        ]);

        if ($response->successful()) {
            $token = $response->json()['token'] ?? null;
            return $token;
        }

        return null;
    }
}
