<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Binds auth
        $this->app->bind(\App\Http\Interfaces\Service\AuthServiceInterface::class, \App\Http\Services\AuthService::class);
        $this->app->bind(\App\Http\Interfaces\Repository\AuthRepositoryInterface::class, \App\Http\Repositories\AuthRepository::class);

        // Binds user
        $this->app->bind(\App\Http\Interfaces\Service\UserServiceInterface::class, \App\Http\Services\UserService::class);
        $this->app->bind(\App\Http\Interfaces\Repository\UserRepositoryInterface::class, \App\Http\Repositories\UserRepository::class);

        // Binds Professional
        $this->app->bind(\App\Http\Interfaces\Service\ProfessionalServiceInterface::class, \App\Http\Services\ProfessionalService::class);
        $this->app->bind(\App\Http\Interfaces\Repository\ProfessionalRepositoryInterface::class, \App\Http\Repositories\ProfessionalRepository::class);

        // Binds Professional Products
        $this->app->bind(\App\Http\Interfaces\Service\ProductsProfessionalServiceInterface::class, \App\Http\Services\ProductsProfessionalService::class);
        $this->app->bind(\App\Http\Interfaces\Repository\ProductsProfessionalRepositoryInterface::class, \App\Http\Repositories\ProductsProfessionalRepository::class);
    }
}
