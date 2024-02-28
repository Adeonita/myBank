<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\WalletRepository;
use App\Interfaces\Repositories\WalletRepositoryInterface;

use App\Services\WalletService;
use App\Interfaces\Services\WalletServiceInterface;

class WalletServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            WalletRepositoryInterface::class,
            WalletRepository::class
        );

        $this->app->bind(
            WalletServiceInterface::class,
            WalletService::class
        );
    }
}