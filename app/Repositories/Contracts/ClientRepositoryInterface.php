<?php

namespace App\Repositories\Contracts;

interface ClientRepositoryInterface
{
    public function all(int $perPage = 10);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
    public function getDeleted(int $perPage = 10);
    public function restore(int $id): bool;
    public function forceDelete(int $id): bool;
}
