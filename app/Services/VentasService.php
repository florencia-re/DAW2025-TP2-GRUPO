<?php

namespace App\Services;

use App\Services\ClientService;
use Illuminate\Support\Facades\Http;

class VentasService
{
    protected $clientService;
    protected $userService;

    // Inyección de dependencia del servicio
    public function __construct(ClientService $clientService, UserService $userService)
    {
        $this->clientService = $clientService;
        $this->userService = $userService;
    }

    public function listarVentasPorCuit($clientId, $token)
    {
        // Ejemplo de uso del servicio de clientes dentro del servicio de ventas
        $cliente = $this->clientService->findClient($clientId);
        if (!$cliente) {
            return null;
        } else {
            $clienteCuit = $cliente->cuit;
            $ventas = $this->fetchApi($clienteCuit, $token);
            return $ventas;
        }
    }

    public function fetchApi($cuit, $token)
    {
        //http://localhost/daw2025/TP/Public/ventas
        $response = Http::withToken($token)->get('http://localhost/daw2025/TP/Public/ventas');
        $data = $response->json();

        $ventasCliente = array_filter($data, function ($venta) use ($cuit) {
            return $venta['cuit_cliente'] === $cuit;
        });

        return $ventasCliente;
    }
}
