@extends('layouts.app')

@section('subtitle', 'Produk')
@section('content')

    <div class="grid grid-cols-1 gap-4 p-4">
        <div class="flex flex-col">
            {{-- <div class="block sm:flex items-center rounded-t-lg justify-between mb-3 lg:mt-1.5">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Category</h1>
                </div>

                <div class="items-center justify-between block sm:flex dark:divide-gray-700">
                    <div class="md:flex items-center mb-4 hidden sm:mb-0">

                        <div class="flex items-center w-full sm:justify-end">
                            <div class="flex gap-3">
                                <div class="selected-info text-gray-500 dark:text-gray-300 hidden">0 data selected</div>
                                <button data-tooltip-target="delete-button" data-tooltip-placement="bottom"
                                    type="button" class="bg-red-500 rounded-lg text-white text-sm p-3">
                                    <i class="fa-solid fa-trash-can pe-2"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">


                        <div class="flex items-center">
                            <label for="items_per_page" class="pe-2 text-gray-700 dark:text-gray-400">Rows per
                                page</label>
                            <select name="items_per_page" id="items_per_page"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="5" {{ $paginate == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $paginate == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ $paginate == 15 ? 'selected' : '' }}>15</option>
                                <option value="25" {{ $paginate == 25 ? 'selected' : '' }}>25</option>
                            </select>
                        </div>
                        <label for="products-search" class="sr-only">Search</label>
                        <div class="relative w-48 sm:w-64 xl:w-72">
                            <input type="text" name="email" id="products-search"
                                class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search products by name">
                        </div>

                        <button id="createProductButton"
                            class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
                            type="button" data-drawer-target="drawer-create-category-default"
                            data-drawer-show="drawer-create-category-default"
                            aria-controls="drawer-create-category-default" data-drawer-placement="right">
                            <i class="fa-solid fa-plus pe-2"></i>New Category
                        </button>

                    </div>

                </div>
            </div>
        </div> --}}
        <div class="mb-4 flex justify-between">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Data products</h1>

        </div>
        <div class="relative bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
            <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
              <div class="w-full md:w-1/2">
                <form class="flex items-center" action="{{ route('admin.product.categories-produk') }}" method="GET">
                  <label for="simple-search" class="sr-only">Search</label>
                  <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                      <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                      </svg>
                    </div>
                    <input type="text" id="categorySearch" name="categorySearch" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" value="{{$search}}">
                  </div>
                </form>
              </div>
              <button type="button" data-drawer-target="drawer-create-category-default"
                data-drawer-show="drawer-create-category-default" aria-controls="drawer-create-category-default"
                data-drawer-placement="right"
                class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">

                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                Add Category
            </button>
            </div>

            <x-tables.admin.category.table-category :categories="$categories"
                routeUpdate="admin.product.categories-produk.update"
                routeDelete="admin.product.categories-produk.delete" />
          </div>



        </div>


        <div id="drawer-create-category-default"
            class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
            tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
            <h5 id="drawer-label"
                class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">New
                category</h5>
            <button type="button" data-drawer-dismiss="drawer-create-category-default"
                aria-controls="drawer-create-category-default"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
            <form action="{{ route('admin.product.categories-produk.add') }}" method="POST" class="overflow-x-auto h-5/6"
                enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Type product name" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea id="description" rows="4" name="description"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter event description here" value="{{ old('desc') }}">{{ old('desc') }}</textarea>
                        @error('description')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="bottom-0 left-0 flex justify-center w-full pb-4 space-x-4 md:px-4 md:absolute">
                        <button type="submit"
                            class="text-white w-full justify-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Add Category
                        </button>
                        <button type="button" data-drawer-dismiss="drawer-create-category-default"
                            aria-controls="drawer-create-category-default"
                            class="inline-flex w-full justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            <svg aria-hidden="true" class="w-5 h-5 -ml-1 sm:mr-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </button>
                    </div>
            </form>
        </div>
    </div>


    {{-- TOOLTIP --}}
    <div id="delete-button" role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-700 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-900">
        Delete
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
    <div id="export-button" role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-700 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-900">
        Export
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>



@endsection
