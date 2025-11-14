<?php

namespace App\Services;


use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserService
{
    public function __construct(protected UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Devuelve todos los usuarios (paginados).
     */
    public function listUsers()
    {
        return $this->user->getAll();
    }

    /**
     * Crea un nuevo usuario.
     *  Se usa Hash::make() para encriptar la contraseña antes de guardarla.
     */
    public function createUser(array $data)
    {
        $baseUrl = 'http://localhost/daw2025/TP/Public/usuarios';

        Http::post($baseUrl, [
            'nombre_usuario' => $data['name'],
            'email' => $data['email'],
            'contrasena' => $data['password'],
            'rol' => $data['role']
        ]);

        $data['password'] = Hash::make($data['password']);

        return $this->user->create($data);
    }

    /**
     * Obtiene un usuario para editar.
     */
    public function getUser($id)
    {
        return $this->user->findById($id);
    }

    /**
     * Actualiza un usuario existente.
     */
    public function updateUser($id, array $data)
    {
        $user = $this->user->findById($id);
        return $this->user->update($user, $data);
    }

    /**
     * Elimina un usuario.
     */
    public function deleteUser($id)
    {
        return $this->user->delete($id);
    }
}
