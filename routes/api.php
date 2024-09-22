<?php

use Auth\CreateUserController;
use Auth\LoginUserController;
use Auth\LogoutUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/
Route::get(
    '/status', static function () {
    return 'ok';
    }
);

Route::name('user.')->prefix('user')
    ->group(
        function (): void {
            Route::post('/create', 'Auth\CreateUserController')
                ->name('create');
            Route::post('/login', 'Auth\LoginUserController')
                ->name('login');
            Route::post('/logout', 'Auth\LogoutUserController')
                ->name('logout');
        }
    );

Route::name('coins')->prefix('coins')
    ->group(
        function (): void {
            Route::post('store', 'StoreCoinsController')->name('store-coins');
            Route::get('get-prices', 'GetCoinsPricesController')->name('get-prices');
        }
    );
