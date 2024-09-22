<?php

namespace App\Http\Controllers;

use App\Http\Resources\CoinResource;
use App\Services\StoreCoinsService ;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoreCoinsController extends Controller
{
    /**
     * @param StoreCoinsService $storeCoinsService
     * @return AnonymousResourceCollection
     */
    public function __invoke(
        StoreCoinsService $storeCoinsService
    ): AnonymousResourceCollection {
        try {
            $response = $storeCoinsService();
        } catch (GuzzleException|\JsonException $exception) {
            logger()->error(
                'An error happened when trying to get and store coins at StoreCoinsController: ',
                [$exception]
            );
        }

        return CoinResource::collection($response);
    }
}
