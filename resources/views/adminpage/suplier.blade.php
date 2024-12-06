@extends('layouts.app')

@section('subtitle', 'Suplier')

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    @vite(['resources/js/admin/supplier.js'])
    @if (session('openDrawer'))
        {{-- <script>
            $(document).ready(function(){
                var id = {{ session('openDrawer') }};
                setTimeout(function () {
                    document.getElementById(`drawer-update-button-product-${id}`).click();
                }, 500);
            })
            document.addEventListener("DOMContentLoaded", function(event) {
            });
        </script> --}}
        {{-- @vite(['resources/js/admin/openDrawer.js']) --}}
    @endif
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
                <x-tables.admin.suppliers.table-suppliers :suppliers="$suppliers" />
            </div>
        </div>

    </div>
@endsection
