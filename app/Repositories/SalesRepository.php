<?php

namespace App\Repositories;

use App\Models\Sales;
use App\Repositories\Contracts\SalesRepositoryInterface;
use Illuminate\Support\Facades\Http;

class SalesRepository implements SalesRepositoryInterface
{
    protected $baseUrl = 'http://localhost/daw2025/TP/Public/ventas';


    public function __construct(protected Sales $sales) {}

    public function getAll(int $perPage = 10, $token)
    {


        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get($this->baseUrl, [
            'per_page' => $perPage
        ]);

        return $response->successful() ? $response->json() : response()->json(['error' => 'Falla en recibir ventas'], 500);
    }
}
