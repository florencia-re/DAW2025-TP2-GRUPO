<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Http;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(protected User $user) {}

    public function getAll(int $perPage = 10)
    {
        return $this->user->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->user->find($id);
    }

    public function create(array $data)
    {

        return $this->user->create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->user->find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        return $this->user->destroy($id);
    }
}
