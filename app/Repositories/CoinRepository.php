<?php

namespace App\Repositories;

use App\Coin;
use App\Repositories\Contracts\CoinRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

final class CoinRepository implements CoinRepositoryInterface
{
    protected $model;

    /**
     * @param $model Coin
     *
     * @return void
     */
    public function __construct(Coin $model)
    {
        $this->model = $model;
    }

    /**
     * @param $parameters array<string, string| int>
     *
     * @return bool
     * @throws Exception
     */
    public function createMany(array $parameters): bool
    {
        $this->deleteAllCoins();

        return $this->model->insert($parameters);
    }

    public function defineCreationDateTime(array $data): bool
    {

        return $this->model->where('created_at', null)->update($data);
    }

    /**
     * @throws Exception
     */
    public function deleteAllCoins(): void
    {
        $this->model->truncate();
    }

    public function getAllCoins(): Collection
    {
        return $this->model->get();
    }

    public function searchForCoins(string $search): Collection
    {
        $search .= strtolower($search);
        $parameters = explode(',', $search);

        return $this->model->whereIn('symbol', $parameters)->get();
    }
}
