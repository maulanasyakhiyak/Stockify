<?php

namespace App\Livewire;

use App\Repositories\Categories\CategoriesRepository;
use App\Services\Product\ProductService;
use Livewire\Component;

class DataProduct extends Component
{
    public $products = []; // Menyimpan semua produk

    public $categories = [];

    public $search = ''; // Menyimpan input pencarian

    protected $categoryRepository;

    public function mount(ProductService $productService, CategoriesRepository $categoryRepository)
    {
        $this->products = $productService->getAllProduct();
        $this->categories = $categoryRepository->getCategories();
    }

    public function updatedSearch()
    {
        $this->products = app(ProductService::class)->searchProducts($this->search);
    }

    public function render()
    {
        return view('livewire.data-product');
    }
}
