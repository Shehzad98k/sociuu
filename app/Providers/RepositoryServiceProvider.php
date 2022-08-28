<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\GroupRepositoryInterface;
use App\Repositories\GroupRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
