<?php

namespace App\Providers;

use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Categories\CategoriesRepositoryImplement;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryImplement;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Repositories\ProductStock\ProductStockRepositoryImplement;
use App\Repositories\StockTransaction\StockTransactionRepository;
use App\Repositories\StockTransaction\StockTransactionRepositoryImplement;
use App\Services\Categories\CategoriesService;
use App\Services\Categories\CategoriesServiceImplement;
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
        $this->app->bind(ProductRepository::class, ProductRepositoryImplement::class);

        $this->app->bind(ProductService::class, ProductServiceImplement::class);

        $this->app->bind(CategoriesRepository::class, CategoriesRepositoryImplement::class);

        $this->app->bind(CategoriesService::class, CategoriesServiceImplement::class);

        $this->app->bind(StockTransactionRepository::class, StockTransactionRepositoryImplement::class);

        $this->app->bind(ProductStockRepository::class, ProductStockRepositoryImplement::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
