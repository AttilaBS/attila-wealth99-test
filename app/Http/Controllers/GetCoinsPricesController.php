<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCoinsFormRequest;
use App\Http\Resources\CoinResource;
use App\Services\GetCoinsPricesService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetCoinsPricesController extends Controller
{
    public function __invoke(
        GetCoinsFormRequest $request,
        GetCoinsPricesService $getCoinsPricesService
    ): AnonymousResourceCollection {
        $validated = $request->validated();
        $coins = $getCoinsPricesService($validated);

        return CoinResource::collection($coins);
    }
}
