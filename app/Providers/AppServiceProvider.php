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

        // Binds Produtos
        $this->app->bind(\App\Http\Interfaces\Service\ProdutosServiceInterface::class, \App\Http\Services\ProdutosService::class);
        $this->app->bind(\App\Http\Interfaces\Repository\ProdutosRepositoryInterface::class, \App\Http\Repositories\ProdutosRepository::class);

        // Binds Adicionais
        $this->app->bind(\App\Http\Interfaces\Service\AdicionaisServiceInterface::class, \App\Http\Services\AdicionaisService::class);
        $this->app->bind(\App\Http\Interfaces\Repository\AdicionaisRepositoryInterface::class, \App\Http\Repositories\AdicionaisRepository::class);

        // Binds Opcoes
        $this->app->bind(\App\Http\Interfaces\Service\OpcoesServiceInterface::class, \App\Http\Services\OpcoesService::class);
        $this->app->bind(\App\Http\Interfaces\Repository\OpcoesRepositoryInterface::class, \App\Http\Repositories\OpcoesRepository::class);

        // Binds Categorias
        $this->app->bind(\App\Http\Interfaces\Service\CategoriaServiceInterface::class, \App\Http\Services\CategoriaService::class);
        $this->app->bind(\App\Http\Interfaces\Repository\CategoriaRepositoryInterface::class, \App\Http\Repositories\CategoriaRepository::class);
    }
}
