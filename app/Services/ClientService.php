<?php

namespace App\Services;


use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService
{


    public function __construct(protected ClientRepositoryInterface $client)
    {
        $this->client = $client;
    }

    // --- MÉTODOS CRUD (INTERFAZ DE REPOSITORIO) ---

    /**
     * Obtiene todos los clientes activos paginados.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllClients(int $perPage = 10): LengthAwarePaginator
    {
        // El repositorio debe usar ->paginate($perPage)
        return $this->client->all($perPage);
    }

    /**
     * Obtiene todos los clientes eliminados lógicamente (papelera), paginados.
     * * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getArchivedClients(int $perPage = 10): LengthAwarePaginator
    {
        // CORREGIDO: Llamamos a un método que debe devolver un Paginator
        return $this->client->getDeleted($perPage);
    }

    /**
     * Busca un cliente por ID.
     *
     * @param int $id
     * @return Client|null
     */
    public function findClient(int $id): ?Client
    {
        return $this->client->find($id);
    }

    /**
     * Crea un nuevo cliente.
     *
     * @param array $data
     * @return Client
     */
    public function createClient(array $data): Client
    {
        return $this->client->create($data);
    }

    /**
     * Actualiza un cliente existente.
     *
     * @param int $id
     * @param array $data
     * @return Client|null
     */
    public function updateClient(int $id, array $data): ?Client
    {
        return $this->client->update($id, $data);
    }

    /**
     * Elimina lógicamente un cliente (Soft Delete).
     *
     * @param int $id
     * @return bool
     */
    public function deleteClient(int $id): bool
    {
        return $this->client->delete($id);
    }

    /**
     * Restaura un cliente de la papelera.
     *
     * @param int $id
     * @return bool
     */
    public function restoreClient(int $id): bool
    {
        return $this->client->restore($id);
    }

    /**
     * Elimina permanentemente un cliente (Force Delete).
     *
     * @param int $id
     * @return bool
     */
    public function forceDeleteClient(int $id): bool
    {
        // NUEVO: Llama al repositorio para la eliminación permanente
        return $this->client->forceDelete($id);
    }

    // --- LÓGICA DE NEGOCIO ESPECIAL: VENTAS EXTERNAS ---

    /**
     * Obtiene las ventas de un cliente específico desde un servicio externo.
     * Incluye simulación de autenticación JWT y manejo de errores HTTP.
     *
     * @param int $clientId
     * @return array Contiene 'sales' (array de ventas) y 'status' (resultado de la operación).
     */
}
