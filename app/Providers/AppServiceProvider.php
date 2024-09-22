<?php

namespace App\Providers;

use App\Repositories\CoinRepository;
use App\Repositories\Contracts\CoinRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CoinRepositoryInterface::class, CoinRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
