<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Capa de acceso a datos del modelo User.
 * Se encarga de interactuar con la base de datos.
 */
class UserRepository
{
    /**
     * Devuelve todos los usuarios paginados.
     */
    public function getAllPaginated($perPage = 10)
    {
        return User::orderBy('id', 'asc')->paginate($perPage);
    }

    /**
     * Busca un usuario por su ID.
     */
    public function findById($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Crea un nuevo usuario en la base de datos.
     */
    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    /**
     * Actualiza un usuario existente.
     */
    public function update(User $user, array $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user;
    }

    /**
     * Elimina un usuario por ID.
     */
    public function delete($id)
    {
        return User::findOrFail($id)->delete();
    }
}
