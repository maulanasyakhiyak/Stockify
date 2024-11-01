<?php

namespace App\Livewire;

use App\Repositories\Categories\CategoriesRepository;
use App\Services\Categories\CategoriesService;
use Livewire\Component;

class DataCategories extends Component
{
    public $categories = [];

    public $search = '';

    public function mount(CategoriesRepository $categoryRepository)
    {
        $this->categories = $categoryRepository->getCategories();
    }

    public function render()
    {

        $this->categories = app(CategoriesService::class)->searchCategories('name', $this->search);

        return view('livewire.data-categories');
    }
}
