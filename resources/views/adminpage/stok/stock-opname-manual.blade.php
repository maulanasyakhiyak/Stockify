@extends('adminpage.stok.stock-opname')



@section('content-opname')
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
                    <input type="text" id="stock-opname-search" autocomplete="off" name="stock-opname-search"
                        class="no-enter block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Search">
                    <ul id="autocomplete-results"
                        class="w-full rounded-lg hidden absolute border shadow-sm overflow-hidden dark:border-gray-600"
                        style=""></ul>
                </div>
            </form>
        </div>
    </div>

    <div class="h-72">
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
                        <form action="{{ route('admin.stok.productStok.opname') }}" id="form-stock-opname" class="inline" method="POST">
                            @csrf
                            <tbody id="item-search-append">

                            </tbody>
                        </form>
                    </table>
                </div>
            </div>

        </div>
        <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 hidden" role="alert" id="alert-opname">
            <p class="font-bold">Tidak Bisa opname</p>
            <p id="error-message-opname"></p>
        </div>
        <div class="w-full flex justify-end mt-4">
            <button data-button-start-opname="manual"
                        class="flex items-center gap-2 justify-center w-full px-4 py-2 text-sm font-medium
                        text-gray-50 bg-blue-500 border border-gray-100 rounded-lg md:w-auto focus:outline-none
                        hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-200
                        dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600
                        dark:hover:text-white dark:hover:bg-gray-700 disabled:bg-blue-300 disabled:hover:bg-blue-300" disabled>
                Mulai
            </button>
        </div>
    </div>
</div>
@endsection
