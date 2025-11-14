<?php

namespace App\Repositories\Contracts;

interface SalesRepositoryInterface
{

    public function getAll(int $perPage = 10, $token);
}
