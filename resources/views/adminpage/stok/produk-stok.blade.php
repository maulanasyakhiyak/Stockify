@extends('layouts.admin')

@section('subtitle', 'Stok')

@section('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    @vite(['resources/js/stock.js'])
@endsection

@section('other_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="original" content="{{ route('admin.stok.riwayat-transaksi') }}">
@endsection

@section('content')


    <div class="grid grid-cols-1 gap-4 p-4">
        <div class="flex flex-col">
            <div class="mb-4 flex justify-between">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Product Stock</h1>
            </div>
            <div class="relative bg-white shadow dark:bg-gray-800 sm:rounded-lg">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
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
                                <form action="{{ route('admin.stok.productStok') }}" method="GET">
                                    <input type="text" id="simple-search"
                                        class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Search by product name" name="search"
                                        value="{{ request()->get('search') ?? '' }}">
                                </form>

                            </div>
                        </form>
                    </div>
                    <div class="">
                        <button type="button" data-target-modal="stock-opname-modal" id="stock-opname-button"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text
                        text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm focus:outline-none
                        focus:ring-2 focus:ring-offset-2 
                        focus:ring-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus
                        ring-blue-600 dark:focus:ring-blue-700">Mulai
                            stock opname</button>
                    </div>
                </div>
                <x-tables.admin.product-stock.table-product-stock :productStock="$productStock" />
            </div>
        </div>

    </div>


    <div class="hidden transition-all duration-500 ease-in-out fixed h-screen w-full z-50 top-0 right-0 flex items-center justify-center bg-gray-800 bg-opacity-0"
        tabindex="-1" id="stock-opname-modal">
        <div class="relative p-4 w-full max-w-md max-h-full">

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 p-4 animationDrop" data-modal="body">

                <div class="flex justify-between border-b">
                    <h2 class="text-xl font-semibold mb-3 text-gray-700 dark:text-gray-50">
                        Item Setting
                    </h2>
                    <button data-hide-modal="stock-opname-modal" class="absolute right-4 top-4"><i
                            class="fa-solid fa-x text-gray-400"></i></button>
                </div>

                <div class="">

                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload
                        file</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="file_input_help" id="file_input" type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX.
                        800x400px).</p>

                </div>

            </div>

        </div>
    </div>
@endsection
