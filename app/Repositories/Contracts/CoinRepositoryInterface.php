<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CoinRepositoryInterface
{
    public function createMany(array $parameters): bool;

    public function defineCreationDateTime(array $data): bool;

    public function deleteAllCoins(): void;

    public function getAllCoins(): Collection;

    public function searchForCoins(string $search): Collection;
}
