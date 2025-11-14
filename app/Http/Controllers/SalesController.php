<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestSalesController;
use App\Services\VentasService;
use App\Models\Client;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    public function __construct(protected VentasService $ventasService) {}

    public function listSalesByCuit(RequestSalesController $request)
    {
        $clientCuit = $request->validated('cuit');

        // DEBUG: Ver estado de sesión
        Log::info('Estado de sesión al solicitar ventas', [
            'authenticated' => session('external_api_authenticated'),
            'has_cookies' => !empty(session('external_api_cookies')),
            'cookies' => session('external_api_cookies'),
            'cuit_solicitado' => $clientCuit
        ]);

        // Verificar autenticación con API externa
        if (!session('external_api_authenticated')) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para acceder a las ventas.');
        }

        // Obtener ventas del servicio
        $sales = $this->ventasService->listSalesByCuit($clientCuit);

        Log::info('Resultado de listSalesByCuit', [
            'total_ventas' => count($sales),
            'ventas' => $sales
        ]);

        if (empty($sales)) {
            return redirect()->back()->with('error', 'Cliente sin ventas.');
        }

        $client = Client::where('cuit', $clientCuit)->firstOrFail();

        return view('sales.index', compact('client', 'sales'));
    }
}
