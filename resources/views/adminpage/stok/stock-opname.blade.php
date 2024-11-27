@extends('layouts.admin')

@section('subtitle', 'Stok')

@section('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .ui-menu .ui-menu-item:hover {
            background-color: #4CAF50 !important;
            /* Ganti dengan warna latar belakang hover */
            color: white !important;
            /* Ganti dengan warna teks hover */
        }
    </style>
@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    @vite(['resources/js/stock-opname.js'])
@endsection

@section('other_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="original" content="{{ route('admin.stok.riwayat-transaksi') }}">
@endsection

@section('content')
    <div class="mx-40 my-10 p-4">
        <div class="flex items-center gap-2">
            <a href="/admin/stok/product-stock"
                class=" flex items-center justify-center rounded-full w-8 h-8 bg-gray-200 text-gray-500">
                <i class="fa-solid fa-angle-left"></i>
            </a>
            <div class="font-semibold text-2xl text-gray-900 sm:text-2xl dark:text-white">Stock Opname</div>
        </div>
        <div
            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 mt-3">
            <ul class="flex flex-wrap -mb-px">

                <li class="me-2">
                    <div data-tab="manual-input"
                        class="inline-block cursor-pointer p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500 active">
                        Manual</div>
                </li>
                <li class="me-2">
                    <div data-tab="csv-input"
                        class="inline-block cursor-pointer p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        aria-current="page">With CSV</div>
                </li>

            </ul>
        </div>

        <div id="manual-input" class="mt-8">
            <div class="mb-4">
                <div class="text-gray-900 dark:text-white font-semibold text-lg mb-2">Add product</div>
                <div class="w-full">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="stock-search" name="search"
                                class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search">
                            <ul id="autocomplete-results"
                                class="w-full rounded-lg hidden absolute border shadow-sm overflow-hidden dark:border-gray-600"
                                style=""></ul>
                        </div>
                    </form>
                </div>
            </div>

            <div class="min-h-72">
                <div class=" text-gray-800 dark:text-gray-300 h-full flex justify-center items-center" id="search-info">
                    <div class="">Search to add product</div>
                </div>
                <div class="hidden" id="product-list-result">
                    <div class="rounded-lg overflow-hidden border dark:border-gray-700">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                    <tr class="">
                                        <th scope="col" class="p-2 w-80">
                                            Product name
                                        </th>
                                        <th scope="col" class="p-2 w-60">
                                            SKU
                                        </th>
                                        <th scope="col" class="p-2">
                                            Stock
                                        </th>
                                        <th scope="col" class="p-2 w-10">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="item-search-append">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div id="csv-input" class="hidden mt-8">
            asdasd
        </div>
        <div class="w-full flex justify-end mt-4">
            <button     id="button-start-opname"
                        class="flex items-center gap-2 justify-center w-full px-4 py-2 text-sm font-medium
                        text-gray-50 bg-blue-500 border border-gray-100 rounded-lg md:w-auto focus:outline-none
                        hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-200
                        dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600
                        dark:hover:text-white dark:hover:bg-gray-700 disabled:bg-blue-300 disabled:hover:bg-blue-300" disabled>
                Mulai
            </button>
        </div>
    </div>
@endsection
