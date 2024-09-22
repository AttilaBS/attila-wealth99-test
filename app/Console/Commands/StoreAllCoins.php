<?php

namespace App\Console\Commands;

use App\Helpers\CoinsHelper;
use App\Repositories\Contracts\CoinRepositoryInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class StoreAllCoins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:all-coins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all coins from Gecko API and store its information';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting storeAllCoins command');
        $getAllCoinsService = app(CoinsHelper::class);
        try {
            $coinsToPersist = $getAllCoinsService->parseResponse();
            $coinRepository = app(CoinRepositoryInterface::class);
            $coinRepository->createMany($coinsToPersist);
            $coinRepository->defineCreationDateTime(['created_at' => now()]);
        } catch (GuzzleException|\JsonException $e) {
            logger()->error(
                'An error occurred when executing storeAllCoins: ',
                [$e->getMessage()]
            );
        }
        $this->info('StoreAllCoins command finished');
    }
}
