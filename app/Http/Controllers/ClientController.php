<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Services\ClientService;
use App\Models\Client;

class ClientController extends Controller
{
    protected $clientService;

    // Inyección de dependencia del servicio
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }


    public function index()
    {

        $clients = $this->clientService->getAllClients(10);

        return view('clients.index', compact('clients'));
    }


    public function archived()
    {

        $clients = $this->clientService->getArchivedClients(10);
        return view('clients.archived', compact('clients'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Almacena un recurso recién creado en la base de datos.
     * Usa StoreClientRequest para validación obligatoria.
     */
    public function store(StoreClientRequest $request)
    {
        try {
            $this->clientService->createClient($request->validated());
            return redirect()->route('clients.index')->with('success', 'Cliente creado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al crear el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Actualiza el recurso especificado en la base de datos.
     * Usa UpdateClientRequest para validación obligatoria.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        try {
            $this->clientService->updateClient($client->id, $request->validated());
            return redirect()->route('clients.index')->with('success', 'Cliente actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al actualizar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Elimina lógicamente (soft delete) el recurso especificado.
     */
    public function destroy(Client $client)
    {
        try {
            $this->clientService->deleteClient($client->id);
            return redirect()->route('clients.index')->with('success', 'Cliente enviado a la papelera (eliminación lógica).');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Restaura un cliente eliminado lógicamente.
     */
    public function restore(int $id)
    {
        try {
            $this->clientService->restoreClient($id);
            return redirect()->route('clients.archived')->with('success', 'Cliente restaurado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al restaurar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Elimina PERMANENTEMENTE un cliente de la base de datos.
     */
    public function forceDelete(int $id)
    {
        try {
            $this->clientService->forceDeleteClient($id); // Asumo que este método existe en el servicio
            return redirect()->route('clients.archived')->with('success', 'Cliente eliminado permanentemente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar permanentemente el cliente: ' . $e->getMessage());
        }
    }
}
