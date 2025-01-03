<?php

namespace App\Providers;

use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Categories\CategoriesRepositoryImplement;
use App\Repositories\DetailOpname\DetailOpnameRepository;
use App\Repositories\DetailOpname\DetailOpnameRepositoryImplement;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryImplement;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Repositories\ProductStock\ProductStockRepositoryImplement;
use App\Repositories\RiwayatOpname\RiwayatOpnameRepository;
use App\Repositories\RiwayatOpname\RiwayatOpnameRepositoryImplement;
use App\Repositories\StockTransaction\StockTransactionRepository;
use App\Repositories\StockTransaction\StockTransactionRepositoryImplement;
use App\Repositories\Supplier\SupplierRepository;
use App\Repositories\Supplier\SupplierRepositoryImplement;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryImplement;
use App\Repositories\UserActivity\UserActivityRepository;
use App\Repositories\UserActivity\UserActivityRepositoryImplement;
use App\Services\Categories\CategoriesService;
use App\Services\Categories\CategoriesServiceImplement;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceImplement;
use App\Services\StockTransaction\StockTransactionService;
use App\Services\StockTransaction\StockTransactionServiceImplement;
use App\Services\Supplier\SupplierService;
use App\Services\Supplier\SupplierServiceImplement;
use App\Services\User\UserService;
use App\Services\User\UserServiceImplement;
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

        $this->app->bind(UserService::class, UserServiceImplement::class);
        $this->app->bind(UserRepository::class, UserRepositoryImplement::class);

        $this->app->bind(CategoriesRepository::class, CategoriesRepositoryImplement::class);

        $this->app->bind(UserRepository::class, UserRepositoryImplement::class);

        $this->app->bind(CategoriesService::class, CategoriesServiceImplement::class);

        $this->app->bind(StockTransactionRepository::class, StockTransactionRepositoryImplement::class);

        $this->app->bind(StockTransactionService::class, StockTransactionServiceImplement::class);

        $this->app->bind(ProductStockRepository::class, ProductStockRepositoryImplement::class);

        $this->app->bind(SupplierRepository::class, SupplierRepositoryImplement::class);

        $this->app->bind(SupplierService::class, SupplierServiceImplement::class);

        $this->app->bind(RiwayatOpnameRepository::class, RiwayatOpnameRepositoryImplement::class);

        $this->app->bind(DetailOpnameRepository::class, DetailOpnameRepositoryImplement::class);

        $this->app->bind(UserActivityRepository::class, UserActivityRepositoryImplement::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
