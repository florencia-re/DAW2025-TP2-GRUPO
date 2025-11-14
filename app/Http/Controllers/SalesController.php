<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestSalesController;
use App\Services\VentasService;


class SalesController extends Controller
{


    public function __construct(protected VentasService $ventasService) {}


    public function listSalesByCuit(RequestSalesController $request)
    {
        $clientCuit = $request->validated('cuit');

        $token = session('external_api_token');

        dd([
            'token' => $token,
            'tiene_token' => !is_null($token),
            'longitud' => $token ? strlen($token) : 0
        ]);
        // Verificar que hay token
        if (!$token) {
            return redirect()->back()
                ->with('error', 'No estás autenticado en el sistema de ventas. Por favor, cierra sesión y vuelve a iniciar.');
        }

        $ventas = $this->ventasService->listSales($token, $clientCuit);
        if (!$ventas) {
            return redirect()->back()->with('error', 'Cliente sin ventas.');
        }
        return view('sales.index', compact('ventas'));
    }
}
