<?php

namespace App\Services;

use App\Repositories\UserRepository;

/**
 * Capa de lógica de negocio.
 * Aquí se define qué se hace, no cómo se accede a los datos.
 */
class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Devuelve todos los usuarios (paginados).
     */
    public function listUsers()
    {
        return $this->repository->getAllPaginated();
    }

    /**
     * Crea un nuevo usuario.
     */
    public function createUser(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Obtiene un usuario para editar.
     */
    public function getUser($id)
    {
        return $this->repository->findById($id);
    }

    /**
     * Actualiza un usuario existente.
     */
    public function updateUser($id, array $data)
    {
        $user = $this->repository->findById($id);
        return $this->repository->update($user, $data);
    }

    /**
     * Elimina un usuario.
     */
    public function deleteUser($id)
    {
        return $this->repository->delete($id);
    }
}
