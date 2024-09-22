<?php

namespace Feature\Coins;

use App\Coin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoinsCreationTest extends TestCase
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
        $this->assertDatabaseHas('coins', [
            'coin_api_id' => $coinsToRetrieve->first()->coin_api_id,
            'name' => $coinsToRetrieve->first()->name,
            'symbol' => $coinsToRetrieve->first()->symbol,
            'price' => $coinsToRetrieve->first()->price,
            'created_at' => $coinsToRetrieve->first()->created_at,
        ]);
        $this->assertSame(400, $coinsToRetrieve->count());
    }
}
