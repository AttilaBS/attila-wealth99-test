<?php

namespace Feature\Coins;

use App\Coin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoinsPricesRetrievalTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Testing if prices retrieval occurs correctly.
     */
    public function testIfCanRetrieveCoinsPricesCorrectly(): void
    {
        $coinsToRetrieve = factory(Coin::class, 400)->create();

        $response = $this->getJson(route('coins.get-prices'));
        $response->assertStatus(200);
    }
}
