<?php

namespace App\Http\Controllers;

use App\Coin;
use App\Http\Resources\CoinResource;
use App\Services\StoreCoinsService ;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoreCoinsController extends Controller
{
    /**
     * @param StoreCoinsService $storeCoinsService
     * @return AnonymousResourceCollection|string
     */
    public function __invoke(
        StoreCoinsService $storeCoinsService
    ) {
        try {
            $coinsCreated = $storeCoinsService();
            if ($coinsCreated) {
                $coins = app(Coin::class)->all();
            }
        } catch (GuzzleException|\JsonException|\Exception $exception) {
            logger()->error(
                'An error happened when trying to get and store coins at StoreCoinsController: ',
                [$exception]
            );
            return json_encode($exception->getMessage());
        }

        return CoinResource::collection($coins);
    }
}
