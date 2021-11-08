<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\TransactionService;
use App\Repositories\TransactionRepository;

use App\Interfaces\Repositories\TransactionRepositoryInterface;
use App\Interfaces\Services\TransactionServiceInterface;

class TransactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class
        );

        $this->app->bind(
            TransactionServiceInterface::class,
            TransactionService::class
        );
    }
}