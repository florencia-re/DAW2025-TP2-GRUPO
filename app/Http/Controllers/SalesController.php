<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClientService;

class SalesController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function sales(int $id)
    {
        $client = $this->clientService->findClient($id) ?? Client::withTrashed()->findOrFail($id);

        // Llama al servicio para obtener la simulación de ventas
        $result = $this->clientService->getClientSales($client->id);

        $sales = $result['sales'];
        $status = $result['status'];

        return view('clients.sales', compact('client', 'sales', 'status'));
    }
}
