<?php

namespace App\Repositories;

use App\Models\Sales;
use App\Repositories\Contracts\SalesRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SalesRepository implements SalesRepositoryInterface
{
    protected $baseUrl = 'http://localhost/daw2025/TP/Public';


    public function __construct(protected Sales $sales) {}

    public function getAll(int $perPage = 10)
    {

        // Obtener cookies de la sesión
        $cookies = session('external_api_cookies', []);

        if (empty($cookies)) {
            Log::error('No hay cookies de API externa en sesión');
            return [];
        }

        try {
            Log::info('Enviando petición a API externa', [
                'url' => "{$this->baseUrl}/ventas",
                'cookies' => array_keys($cookies),
                'per_page' => $perPage
            ]);

            // Hacer petición con cookies
            $response = Http::withCookies($cookies, 'localhost')
                ->get("{$this->baseUrl}/ventas", [
                    'per_page' => $perPage
                ]);

            Log::info('Respuesta de API externa', [
                'status' => $response->status(),
                'body' => $response->body(), // ← Ver respuesta completa
                'json' => $response->json()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Ventas obtenidas', [
                    'total' => is_array($data) ? count($data) : 'no es array',
                    'estructura' => is_array($data) && !empty($data) ? array_keys($data[0] ?? []) : 'vacío'
                ]);
                $salesToModel = array_map(function ($saleData) {
                    return $this->saleDataToModel($saleData);
                }, $data);
                return $salesToModel;
            }

            Log::warning('API respondió con error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('Error al obtener ventas', ['error' => $e->getMessage()]);
            return [];
        }
    }

    public function saleDataToModel(array $saleData): array
    {
        return [
            'cuitClient' => $saleData['cuit_cliente'],
            'date' => $saleData['fecha'],
            'price' => $saleData['monto']
        ];
    }
}
