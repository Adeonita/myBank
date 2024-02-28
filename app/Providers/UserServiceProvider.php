<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\UserService;
use App\Repositories\UserRepository;

use App\Interfaces\Services\UserServiceInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;


class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );
    }
}