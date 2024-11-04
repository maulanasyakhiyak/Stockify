<?php

namespace App\Livewire;

use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductService;
use Livewire\Component;
use Livewire\WithPagination;

class DataProduct extends Component
{
    use WithPagination;

    public $categories = [];

    public $search = '';

    protected $productService;

    protected $categoryRepository;

    protected $productRepository;

    public function mount(ProductService $productService, CategoriesRepository $categoryRepository, ProductRepository $productRepository)
    {
        $this->productService = $productService; // Simpan service produk
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;

        // Ambil kategori saat komponen dimuat
        $this->categories = $this->categoryRepository->getCategories();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->search) {
            $products = app(ProductRepository::class)->searchProduct(5, $this->search);
        } else {
            $products = app(ProductRepository::class)->getProductPaginate();
        }

        return view('livewire.data-product', [
            'products' => $products,
        ]);
    }
}
