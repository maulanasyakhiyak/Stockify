<?php

namespace App\Providers;

use App\Models\AppSetting;
use App\Services\User\UserService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Services\Product\ProductService;
use App\Repositories\User\UserRepository;
use App\Services\Supplier\SupplierService;
use App\Services\User\UserServiceImplement;
use App\Services\Categories\CategoriesService;
use App\Repositories\Product\ProductRepository;
use App\Services\AppSettings\AppSettingsService;
use App\Repositories\Supplier\SupplierRepository;
use App\Services\Product\ProductServiceImplement;
use App\Repositories\User\UserRepositoryImplement;
use App\Services\UserActivity\UserActivityService;
use App\Services\Supplier\SupplierServiceImplement;
use App\Repositories\Categories\CategoriesRepository;
use App\Services\Categories\CategoriesServiceImplement;
use App\Repositories\Product\ProductRepositoryImplement;
use App\Repositories\DetailOpname\DetailOpnameRepository;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Repositories\UserActivity\UserActivityRepository;
use App\Services\AppSettings\AppSettingsServiceImplement;
use App\Repositories\Supplier\SupplierRepositoryImplement;
use App\Services\StockTransaction\StockTransactionService;
use App\Repositories\RiwayatOpname\RiwayatOpnameRepository;
use App\Services\UserActivity\UserActivityServiceImplement;
use App\Repositories\Categories\CategoriesRepositoryImplement;
use App\Repositories\StockTransaction\StockTransactionRepository;
use App\Repositories\DetailOpname\DetailOpnameRepositoryImplement;
use App\Repositories\ProductStock\ProductStockRepositoryImplement;
use App\Repositories\UserActivity\UserActivityRepositoryImplement;
use App\Services\StockTransaction\StockTransactionServiceImplement;
use App\Repositories\RiwayatOpname\RiwayatOpnameRepositoryImplement;
use App\Repositories\StockTransaction\StockTransactionRepositoryImplement;

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

        $this->app->bind(UserActivityService::class, UserActivityServiceImplement::class);

        $this->app->bind(AppSettingsService::class, AppSettingsServiceImplement::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $settings = AppSetting::first();

            // Jika tidak ada data, berikan nilai default
            if (!$settings) {
                $settings = (object) [
                    'app_name' => 'Stockify',
                    'logo_path' => 'static/images/logo.svg'
                ];
            }
            $view->with('settings', $settings);
        });
    }
}
