<?php

namespace Feature\Coins;

use App\Coin;
use App\Helpers\CoinsHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CoinsPricesRetrievalTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Testing if prices retrieval occurs correctly.
     */
    public function testIfCanRetrieveAllCoinsPricesCorrectly(): void
    {
        $coinsToRetrieve = factory(Coin::class, 400)->create();

        $response = $this->getJson(route('coins.get-prices'));
        $response->assertStatus(200);
        $this->assertDatabaseHas('coins', [
            'coin_api_id' => $coinsToRetrieve->first()->coin_api_id,
            'name' => $coinsToRetrieve->first()->name,
            'symbol' => $coinsToRetrieve->first()->symbol,
            'price' => $coinsToRetrieve->first()->price,
            'created_at' => $coinsToRetrieve->first()->created_at,
        ]);
        $this->assertSame(400, $coinsToRetrieve->count());
    }

    public function testIfCanRetrieveSpecificCoins(): void
    {
        $desiredSymbols = app(CoinsHelper::class)->coinsSymbolsList();
        $symbolToCreateAtDatabase = array_map('strtolower', $desiredSymbols);
        $index = random_int(0, count($symbolToCreateAtDatabase) - 1);
        $symbolToValidate = $symbolToCreateAtDatabase[$index];
        $coinsToRetrieve = factory(Coin::class, 50)->create([
            'symbol' => $symbolToValidate,
        ]);

        $randomSymbols = Arr::random($desiredSymbols, random_int(1, 3));
        $randomSymbolsForQueryString = implode('&', $randomSymbols);
        $appended = "{$randomSymbolsForQueryString}&{$symbolToValidate}";

        $response = $this->getJson(
            url("api/coins/get-prices?coins={$appended}")
        );
        $response->assertStatus(200)
            ->assertJsonFragment(
                [
                    'symbol' => $symbolToValidate,
                ]
            );
    }
}
