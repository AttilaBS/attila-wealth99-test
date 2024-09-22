<?php

namespace App\Services;

use App\Helpers\CoinsHelper;
use App\Repositories\CoinRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Collection;
use JsonException;

class StoreCoinsService
{
    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function __invoke(): bool
    {
        $coinsToStore = app(CoinsHelper::class)->parseResponse();

        return app(CoinRepository::class)->createMany($coinsToStore);
    }
}
