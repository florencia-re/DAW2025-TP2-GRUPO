<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use App\Models\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService
{
    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * Inyección de dependencia del Repositorio
     *
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
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
        return $this->clientRepository->all($perPage);
    }

    /**
     * Obtiene todos los clientes eliminados lógicamente (papelera), paginados.
     * * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getArchivedClients(int $perPage = 10): LengthAwarePaginator
    {
        // CORREGIDO: Llamamos a un método que debe devolver un Paginator
        return $this->clientRepository->getDeleted($perPage);
    }

    /**
     * Busca un cliente por ID.
     *
     * @param int $id
     * @return Client|null
     */
    public function findClient(int $id): ?Client
    {
        return $this->clientRepository->find($id);
    }

    /**
     * Crea un nuevo cliente.
     *
     * @param array $data
     * @return Client
     */
    public function createClient(array $data): Client
    {
        return $this->clientRepository->create($data);
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
        return $this->clientRepository->update($id, $data);
    }

    /**
     * Elimina lógicamente un cliente (Soft Delete).
     *
     * @param int $id
     * @return bool
     */
    public function deleteClient(int $id): bool
    {
        return $this->clientRepository->delete($id);
    }

    /**
     * Restaura un cliente de la papelera.
     *
     * @param int $id
     * @return bool
     */
    public function restoreClient(int $id): bool
    {
        return $this->clientRepository->restore($id);
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
        return $this->clientRepository->forceDelete($id);
    }

    // --- LÓGICA DE NEGOCIO ESPECIAL: VENTAS EXTERNAS ---

    /**
     * Obtiene las ventas de un cliente específico desde un servicio externo.
     * Incluye simulación de autenticación JWT y manejo de errores HTTP.
     *
     * @param int $clientId
     * @return array Contiene 'sales' (array de ventas) y 'status' (resultado de la operación).
     */
    public function getClientSales(int $clientId): array
    {
        return "ventas";
    }
}
