<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class CoinsHelper
{
    /**
     * @throws JsonException|GuzzleException
     */
    public function parseResponse(): array
    {
        $onlyNeededCoins = $this->filteredCoinsList();

        $coinsArray = [];
        $coins = $this->getCoinsPrices($onlyNeededCoins);

        foreach($coins as $id => $price) {
            $price = $price['usd'] ?? null;
            foreach ($onlyNeededCoins as $key => $onlyNeededCoin) {
                if ($id === $onlyNeededCoin['id']) {
                    $coinsArray[] = [
                        'coin_api_id' => $id,
                        'name' => $onlyNeededCoin['name'],
                        'symbol' => $onlyNeededCoin['symbol'],
                        'price' => $price,
                    ];
                }
            }
        }

        return $coinsArray;
    }

    public function coinsList(): array
    {
        return [
            'BTC',
            'BCH',
            'LTC',
            'ETH',
            'DACXI',
            'LINK',
            'USDT',
            'XLM',
            'DOT',
            'ADA',
            'SOL',
            'AVAX',
            'LUNC',
            'MATIC',
            'USDC',
            'BNB',
            'XRP',
            'UNI',
            'MKR',
            'BAT',
            'SAND',
            'EOS',
        ];
    }

    /**
     * HTTP response of gecko API simple/price endpoint (example of an index):
     * "wrapped-terra" => array:1 [
     *     "usd" => 8.752E-5
     * ]
     *
     * @throws JsonException|GuzzleException
     */
    private function getCoinsPrices(array $onlyNeededCoins): array
    {
        $client = new Client();
        $idsToGetPrice = $this->getIdsFromArray($onlyNeededCoins);

        $response = $client->request(
            'GET',
            "https://api.coingecko.com/api/v3/simple/price?ids={$idsToGetPrice}&vs_currencies=usd",
            [
                'headers' => [
                    'accept' => 'application/json',
                    'x-cg-demo-api-key' => config('coin-gecko.demo_api_key'),
                ],
            ]
        );

        return json_decode(
            $response->getBody(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    private function getIdsFromArray(array $onlyNeededCoins): string
    {
        $idsArray = array_column($onlyNeededCoins, 'id');

        return implode(',', $idsArray);
    }

    /**
     * @return array
     * @throws GuzzleException
     * @throws JsonException
     */
    private function filteredCoinsList(): array
    {
        $coinsList = $this->getCoinsList();
        $coinsToFilter = app(CoinsHelper::class)->coinsList();
        $lowerCase = array_map('strtolower', $coinsToFilter);

        return array_filter($coinsList, static function($coin) use ($lowerCase) {
            return in_array($coin['symbol'], $lowerCase, true);
        });
    }

    /**
     * HTTP response of gecko API coins/list endpoint (example of an index):
     * 14212 => array:3 [
     *     "id" => "xcdot"
     *     "symbol" => "dot"
     *     "name" => "xcDOT"
     * ]
     *
     * @throws JsonException|GuzzleException
     */
    private function getCoinsList(): array
    {
        $client = new Client();

        $response = $client->request(
            'GET',
            'https://api.coingecko.com/api/v3/coins/list',
            [
                'headers' => [
                    'accept' => 'application/json',
                    'x-cg-demo-api-key' => config('coin-gecko.demo_api_key'),
                ],
            ]
        );

        return json_decode(
            $response->getBody(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
