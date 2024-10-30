<?php

namespace App\Providers;

use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryImplement;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceImplement;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepository::class,ProductRepositoryImplement::class);

        $this->app->bind(ProductService::class,ProductServiceImplement::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
