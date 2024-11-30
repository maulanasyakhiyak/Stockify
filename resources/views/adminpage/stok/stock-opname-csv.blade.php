@extends('adminpage.stok.stock-opname')



@section('content-opname')

<div class="mt-8 mb-4">
<input class="block w-full text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="upload-opname-csv" type="file">
<p class=" text-gray-500 text-sm dark:text-gray-300 px-1 py-2">Supported
    format : .csv, .xlsx - <a href="{{ route('download-sample-opname') }}" class="hover:text-blue-400">Download sample opname</a></p>
</div> 
<div class="" id="loading-csv-data">
    <div class="hidden" id="product-list-result-csv">
        <div class="rounded-lg overflow-hidden border dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="">
                            <th scope="col" class="p-2">
                                Product name
                            </th>
                            <th scope="col" class="p-2">
                                SKU
                            </th>
                            <th scope="col" class="p-2">
                                Stock fisik
                            </th>
                        </tr>
                    </thead> 
                    <form action="{{ route('admin.stok.productStok.opname') }}" id="form-stock-opname" class="inline" method="POST">
                        @csrf
                        <tbody id="item-csv-append">

                        </tbody>
                    </form>
                </table>
            </div>
        </div>
        <div class="mt-4">
            <label for="keterangan-opname" class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">Keterangan</label>
            <input type="text" id="keterangan-opname" autocomplete="off" name="keterangan-opname"
                    class="mt-2 no-enter block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Tambahkan alasan opname">
        </div>
        <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 hidden" role="alert" id="alert-opname">
            <p class="font-bold">Tidak Bisa opname</p>
            <p id="error-message-opname"></p>
        </div>
        <div class="w-full flex justify-end mt-4">
            <button data-button-start-opname="csv" id="button-start-opname"
                        class="flex items-center gap-2 justify-center w-full px-4 py-2 text-sm font-medium
                        text-gray-50 bg-blue-500 border border-gray-100 rounded-lg md:w-auto focus:outline-none
                        hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-200
                        dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600
                        dark:hover:text-white dark:hover:bg-gray-700 disabled:bg-blue-300 disabled:hover:bg-blue-300" disabled>
                Mulai
            </button>
        </div>
    </div>

    <div role="status" id="loading-csv-opname" class="hidden w-full divide-y divide-gray-200 rounded animate-pulse dark:divide-gray-700 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            </div>
            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
        </div>
        <div class="flex items-center justify-between pt-4">
            <div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            </div>
            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
        </div>
        <div class="flex items-center justify-between pt-4">
            <div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            </div>
            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
        </div>
        <div class="flex items-center justify-between pt-4">
            <div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            </div>
            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
        </div>
        <div class="flex items-center justify-between pt-4">
            <div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            </div>
            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>
</div>

@endsection
