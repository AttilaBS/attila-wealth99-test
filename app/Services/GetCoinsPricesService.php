<?php

namespace App\Services;

use App\Repositories\CoinRepository;

class GetCoinsPricesService
{
    public function __invoke(array $queryParameters)
    {
        $coinRepository = app(CoinRepository::class);
        if (! $queryParameters['coins']) {
            return $coinRepository->getAllCoins();
        }

        return $coinRepository->searchForCoins($queryParameters['coins']);
    }
}
