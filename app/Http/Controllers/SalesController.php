<?php

namespace App\Http\Controllers;



class SalesController extends Controller
{
    protected $ventasService;

    public function __construct(\App\Services\VentasService $ventasService)
    {
        $this->ventasService = $ventasService;
    }

    public function listarVentas($clientId, $userName, $password)
    {
        $ventas = $this->ventasService->listarVentas($clientId, $userName, $password);
        if (!$ventas) {
            return redirect()->back()->with('error', 'Cliente no encontrado o sin ventas.');
        }
        return view('sales.index', compact('ventas'));
    }
}
