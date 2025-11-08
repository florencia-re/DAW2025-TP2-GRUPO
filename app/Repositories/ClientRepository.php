<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientRepository
{
    /**
     * @var Client
     */
    protected $model;

    // Inyección del modelo Eloquent
    public function __construct(Client $model)
    {
        $this->model = $model;
    }


    public function all(int $perPage = 10): LengthAwarePaginator
    {
        // Usamos paginate() para soportar el método links() en la vista
        return $this->model->paginate($perPage);
    }


    public function find(int $id)
    {
        return $this->model->find($id);
    }


    public function create(array $data)
    {
        return $this->model->create($data);
    }


    public function update(int $id, array $data)
    {
        $client = $this->model->find($id);
        if ($client) {
            $client->update($data);
            return $client;
        }
        return null;
    }


    public function delete(int $id): bool
    {
        return $this->model->destroy($id); // destroy realiza soft delete si el modelo usa la trait
    }

    // --- Métodos de Soft Delete / Papelera ---


    public function     getDeleted(int $perPage = 10): LengthAwarePaginator
    {

        return $this->model->onlyTrashed()->paginate($perPage);
    }

    //restaurar cliente
    public function restore(int $id): bool
    {
        $client = $this->model->withTrashed()->find($id);
        if ($client && $client->trashed()) {
            return $client->restore();
        }
        return false;
    }

    //eliminar de forma permanente
    public function forceDelete(int $id): bool
    {
        // encontrar el cliente que está en la papelera
        $client = $this->model->onlyTrashed()->find($id);

        if ($client) {

            return $client->forceDelete();
        }
        return false;
    }
}
