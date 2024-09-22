<?php

namespace App\Repositories\Contracts;

use App\User;

interface UserRepositoryInterface
{
    public function create(array $parameters): User;

    public function find(string $email): ?User;
}
