<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientRepository implements ClientRepositoryInterface
{

    // Inyección del modelo Eloquent
    public function __construct(protected Client $clientModel) {}


    public function all(int $perPage = 10): LengthAwarePaginator
    {
        // Usamos paginate() para soportar el método links() en la vista
        return $this->clientModel->paginate($perPage);
    }


    public function find(int $id)
    {
        return $this->clientModel->find($id);
    }


    public function create(array $data)
    {
        return $this->clientModel->create($data);
    }


    public function update(int $id, array $data)
    {
        $client = $this->clientModel->find($id);
        if ($client) {
            $client->update($data);
            return $client;
        }
        return null;
    }


    public function delete(int $id): bool
    {
        return $this->clientModel->destroy($id); // destroy realiza soft delete si el modelo usa la trait
    }

    // --- Métodos de Soft Delete / Papelera ---


    public function getDeleted(int $perPage = 10): LengthAwarePaginator
    {

        return $this->clientModel->onlyTrashed()->paginate($perPage);
    }

    //restaurar cliente
    public function restore(int $id): bool
    {
        $client = $this->clientModel->withTrashed()->find($id);
        if ($client && $client->trashed()) {
            return $client->restore();
        }
        return false;
    }

    //eliminar de forma permanente
    public function forceDelete(int $id): bool
    {
        // encontrar el cliente que está en la papelera
        $client = $this->clientModel->onlyTrashed()->find($id);

        if ($client) {

            return $client->forceDelete();
        }
        return false;
    }
}
