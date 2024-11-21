@extends('layouts.admin')

@section('subtitle', 'Produk')

@section('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js" integrity="sha512-jEnuDt6jfecCjthQAJ+ed0MTVA++5ZKmlUcmDGBv2vUI/REn6FuIdixLNnQT+vKusE2hhTk2is3cFvv5wA+Sgg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @vite(['resources/js/data-product.js'])
@endsection

@section('other_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="original" content="{{ route('admin.product.data-produk') }}">
@endsection

@section('content')
    <div class="grid grid-cols-1 gap-4 p-4">
        <div class="flex flex-col">
            <div class="mb-4 flex justify-between">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Data products</h1>
                <button type="button" data-drawer-target="drawer-create-product-default"
                    data-drawer-show="drawer-create-product-default" aria-controls="drawer-create-product-default"
                    data-drawer-placement="right"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">

                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Add product
                </button>
            </div>
            <div class="relative bg-white shadow dark:bg-gray-800 sm:rounded-lg">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">

                    <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">

                        <div class="md:flex items-center w-full md:w-auto grid gap-2 grid-cols-2">
                            <button data-button-delete-selected="selected_delete" data-tooltip-target="delete-button"
                                data-target-modal="selected_delete" data-tooltip-placement="bottom" id="delete_selected"
                                class="button-delete" type="button" disabled>
                                <i class="fa-solid fa-trash "></i>
                                Delete
                            </button>
                            <button class="button" data-dropdown-toggle="export-dropdown" type="button">
                                <i class="fa-solid fa-file-arrow-up"></i>
                                Export
                            </button>
                            <div id="export-dropdown"
                                class="z-10 overflow-hidden hidden bg-white divide-y  divide-gray-100 rounded-lg shadow-lg border dark:border-gray-600 w-44 dark:bg-gray-700">
                                <ul class="text-sm  text-gray-700 dark:text-gray-200"
                                    aria-labelledby="export-dropdownButton">
                                    <li>
                                        <a href="{{ route('export-product') }}"
                                            class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 dark:hover:text-white">Export
                                            all</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('export-product-selected') }}" id="export_selected"
                                            class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Export Selected (<span data-attr="selected-data">0</span>)
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <button data-tooltip-target="import-bottom" data-tooltip-placement="bottom"
                                data-target-modal="import-modal" class="button" type="button">
                                <i class="fa-solid fa-file-arrow-down" class="-ml-1 mr-1.5 w-5 h-5"></i>
                                Import
                            </button>
                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="button"
                                type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                    class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Filter
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <div id="filterDropdown"
                                class="z-10 hidden w-48 p-3 bg-white rounded-lg border dark:border-gray-600 shadow dark:bg-gray-700">
                                <form action="{{ route('filter-product') }}" method="POST" id="filter_product"
                                    class="text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconButton">
                                    @csrf
                                    <div class="mb-2">
                                        <label for="category_filter"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                        <select id="category_filter" name="category_filter"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="" selected>All category</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ isset($filter['category']) && $filter['category'] == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <!-- Input untuk Rentang Harga -->
                                    <div class="mb-3">
                                        <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selling
                                            price</div>
                                        <div class="flex gap-1 mb-3">
                                            <div>
                                                <input type="number" name="selling_price_min" id="selling_price_min"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="Min"
                                                    value="{{ isset($filter['selling_price_min']) ? $filter['selling_price_min'] : '' }}">
                                            </div>

                                            <div>
                                                <input type="number" name="selling_price_max" id="selling_price_max"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="Max"
                                                    value="{{ isset($filter['selling_price_max']) ? $filter['selling_price_max'] : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="text-white w-full justify-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        Apply Filter
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center" action="{{ route('admin.product.data-produk') }}"
                            method="GET">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="search" name="search"
                                    class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search" value="{{ $search }}">
                            </div>
                        </form>
                    </div>

                </div>
                <x-tables.admin.product.table-product :products="$products" :categories="$categories"
                    routeUpdate="admin.product.data-produk.update" routeDelete="admin.product.data-produk.delete" />

                    <div class="flex">
                        {{ $products->links() }}
                    </div>
            </div>
        </div>


        <div id="drawer-create-product-default"
            class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
            tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
            <h5 id="drawer-label"
                class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">New
                Product</h5>
            <button type="button" data-drawer-dismiss="drawer-create-product-default"
                aria-controls="drawer-create-product-default"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
            <form action="{{ route('admin.product.data-produk.new') }}" method="POST"
                class="overflow-x-auto h-5/6 p-1  " enctype="multipart/form-data">
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
                        <div class="flex justify-between w-full">
                            <label for="atribute"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Atribute</label>
                            <button type="button" data-add-atribute-target="addFormData" class="cursor-pointer mb-2">
                                <i
                                    class="fa-solid fa-plus text-white bg-blue-500 hover:bg-blue-600 p-[0.2rem] text-xs rounded-full"></i>
                            </button>
                        </div>

                        <div id="addFormData">
                            @if (old('atributes'))
                                @foreach (old('atributes') as $index => $atribute)
                                    <div data-atribute-form={{ $index }} data-atribute-index="{{$index}}" data-atribute-parent="addFormData"
                                        class="mt-2 relative w-full flex overflow-hidden bg-white border divide-x-2 divide-solid dark:divide-gray-500 border-gray-300 text-gray-900 text-sm rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <div class="atribute">
                                            <input type="text" data-index="{{$index}}" name="atributes[{{ $index }}][atribute]"
                                                class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                                                placeholder="Nama"
                                                value="{{ old('atributes.' . $index . '.atribute') }}">
                                        </div>
                                        <div class="value">
                                            <input type="text" data-index="{{$index}}" name="atributes[{{ $index }}][value]"
                                                class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                                                placeholder="Val (optional)"
                                                value="{{ old('atributes.' . $index . '.value') }}">
                                        </div>
                                        <button type="button" @if ($index == 0) disabled @endif
                                            data-remove-atribute-form="{{ $index }}"
                                            class="flex items-center justify-center flex-grow text-gray-900 dark:text-white disabled:text-gray-300 dark:disabled:text-gray-500 dark:hover:text-red-500 hover:text-red-500">
                                            <i class="fa-solid fa-minus "></i>
                                        </button>
                                    </div>
                                @endforeach
                                @else
                                <div data-atribute-form="0" data-atribute-index="0"  class="relative w-full flex overflow-hidden bg-white border divide-x-2 divide-solid dark:divide-gray-500 border-gray-300 text-gray-900 text-sm rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <div class="atribute">
                                        <input type="text" name="atributes[0][atribute]"
                                            class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                                            placeholder="Nama">
                                    </div>
                                    <div class="value">
                                        <input type="text" name="atributes[0][value]"
                                            class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                                            placeholder="Val (optional)">
                                    </div>
                                    <button disabled type="button" data-remove-atribute-form="0"
                                        class="flex items-center justify-center flex-grow text-gray-900 dark:text-white disabled:text-gray-300 dark:disabled:text-gray-500 dark:hover:text-red-500 hover:text-red-500">
                                        <i class="fa-solid fa-minus "></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label for="category-create"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select id="category-create" name="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option hidden selected value="">Select category</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}" {{ old('category') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="product_stock"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                        <input type="text" name="product_stock" id="product_stock"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="0." value="{{ old('product_stock') }}">
                        @error('sku')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <label for="purchase_price"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purchase price</label>
                            <input type="number" name="purchase_price" id="purchase_price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Rp." value="{{ old('purchase_price') }}">
                        </div>

                        <div>
                            <label for="selling_price"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selling price</label>
                            <input type="number" name="selling_price" id="selling_price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Rp." value="{{ old('selling_price') }}">
                            @error('sale_price')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @error('purchase_price')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <div>
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea id="description" rows="4" name="desc"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter event description here" value="{{ old('desc') }}">{{ old('desc') }}</textarea>
                        @error('description')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-center w-full">
                        <label for="product_image" data-dropfile="product_image"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <img class="w-full h-full rounded-lg" src="" alt=""
                                data-image="product_image" hidden>
                            <div class="flex flex-col items-center justify-center pt-5 pb-6" data-noImage="product_image">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                        to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)
                                </p>
                            </div>
                            <input id="product_image" name="product_image" type="file" data-file="product_image"
                                accept="image/*" hidden />
                        </label>
                    </div>


                    <div class="bottom-0 left-0 flex justify-center w-full pb-4 space-x-4 md:px-4 md:absolute">
                        <button type="submit"
                            class="text-white w-full justify-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Add product
                        </button>
                        <button type="button" data-drawer-dismiss="drawer-create-product-default"
                            aria-controls="drawer-create-product-default"
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
    <div id="import-bottom" role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-700 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-600">
        Import file
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
    <div id="export-button" role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-700 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-600">
        Export file
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>

    {{-- MODAL --}}
    <div id="import-modal" tabindex="-1" 
        class="hidden transition-all duration-500 ease-in-out fixed h-screen w-full z-50 top-0 right-0 flex items-center justify-center bg-gray-800 bg-opacity-0">

        <div class="relative p-4 w-full max-w-2xl max-h-full">

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 p-4 animationDrop" data-modal="body">
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-50">Import
                        Products
                    </h2>
                    <button data-hide-modal="import-modal" class="absolute right-4 top-4"><i
                            class="fa-solid fa-x text-gray-400"></i></button>
                </div>
                <div class="flex items-center justify-center w-full">
                    <label for="import_csv" data-dropfile="import_csv"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-sky-500 dark:border-gray-100 rounded-lg cursor-pointer disabled:cursor-default bg-white dark:hover:bg-gray-600 dark:bg-gray-70">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6 text-sky-500">
                            <div class="" id="icon-import">
                                <i class="fa-regular fa-file font-thin text-4xl mb-4"></i>
                            </div>
                            <div id="no-file" class="flex flex-col items-center">
                                <p class="mb-2 text-sm" data-changed="import_csv">
                                    Drag and drop file here or
                                    <span class="font-bold underline">click to upload</span>
                                </p>
                            </div>
                            <div id="filechange" class="hidden">
                                <p class="mb-2 text-sm">
                                    <span id="file_name"></span>
                                    <span class="font-bold underline">change</span>
                                </p>
                            </div>
                            <div id="uploading-file" class="hidden w-96">
                                <p class="mb-2 w-full text-center text-sm uploading_text">
                                    Uploading...
                                </p>
                                <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div id="progress-bar-import-file"
                                        class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-2 leading-none rounded-full">
                                        0%
                                    </div>
                                </div>
                                <div class="w-full text-center mt-4">
                                    <button id="button-cancel-upload"
                                        class="bg-gray-700 dark:bg-gray-800 hover:bg-gray-600
                                                                            p-3 rounded-lg border text-gray-50 dark:border-gray-500 transition-all ease-in-out
                                                                            duration-200 dark:hover:bg-gray-500 dark:text-gray-100 disabled:opacity-30 disabled:hover:bg-gray-700">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                            <div id="uploaded" class="hidden">
                                <p class="mb-2 w-full text-center text-sm text-gray-600 dark:text-gray-400">
                                    Uploaded
                                </p>
                                <div id="animation-uploaded" data-json-animated="{{ asset('animation/success.json') }}"
                                    class="w-40 h-40"></div>
                            </div>
                        </div>
                        <input id="import_csv" name="import_csv" type="file" accept=".csv, .xlsx" hidden />

                    </label>
                </div>
                <div class="flex justify-between items-center w-full mb-4">
                    <p class="mt-2 text-gray-500 text-sm dark:text-gray-300">Supported
                        format : .csv, .xlsx</p>
                    <p class="mt-2 text-gray-500 text-sm dark:text-gray-300">Maximum size :
                        5 MB</p>
                </div>
                <div class="flex justify-end">
                    <form id="form-import-file" action="{{ route('import-product') }}" class="inline" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <button id="submit-import-file" disabled type="submit"
                            class="bg-gray-700 dark:bg-gray-800 hover:bg-gray-600
                                                            p-3 rounded-lg border text-gray-50 dark:border-gray-500 transition-all ease-in-out
                                                            duration-200 dark:hover:bg-gray-500 dark:text-gray-100 disabled:opacity-30 disabled:hover:">
                            Import File
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <!-- delete Modal -->
    <div id="selected_delete" tabindex="-1"
        class="hidden transition-all duration-500 ease-in-out fixed h-screen w-full z-50 top-0 right-0 flex items-center justify-center bg-gray-800 bg-opacity-0">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 animationDrop" data-modal="body">

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4 ">
                    <h3 class="text-gray-500 dark:text-gray-50">Apakah anda yakin ingin
                        menghapus data yang
                        dipilih ?</h3>
                    <div class="modal_body min-h-40 w-full border rounded-lg p-3 text-gray-500 dark:text-gray-50">

                    </div>
                    <div class="flex justify-end">
                        <button data-hide-modal="selected_delete" type="button"
                            class="py-2.5 px-5  text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                        <form action="{{ route('admin.product.data-produk.delete-selected') }}" method="POST"
                            class="inline-flex">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                class="ms-3 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                accept
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Modal footer -->

            </div>
        </div>
    </div>

@endsection
