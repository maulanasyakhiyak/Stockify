<?php

namespace App\Livewire;

use App\Services\Product\ProductService;
use Livewire\Component;
use Illuminate\Support\Facades\Log; // Tambahkan ini
use Illuminate\Support\Facades\File; // Tambahkan ini untuk mengimpor File

class DataProduct extends Component
{
    public $products = []; // Menyimpan semua produk
    public $search = ''; // Menyimpan input pencarian

    public function mount(ProductService $productService)
    {
        // Ambil data produk dari ProductService
        $this->products = $productService->getAllProduct();
    }

    public function updatedSearch() // Fungsi ini akan dipanggil setiap kali `search` diupdate
    {
        // Memfilter produk berdasarkan pencarian
        Log::info('Search updated: ' . $this->search);
        $this->products = app(ProductService::class)->searchProducts($this->search);
    }

    public function render()
    {
        return view('livewire.data-product');
    }
}
