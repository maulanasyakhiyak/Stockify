@extends('layouts.admin')

@section('subtitle', 'Dashboard')
@section('content')
<div class="grid grid-cols-1 gap-4 p-4">
    <div class="w-full flex justify-between pb-0">
        <div
            class="grid grid-cols-5 p-1 hidden lg:grid bg-white border border-gray-200 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class=" text-gray-500 text-sm font-bold p-2 text-center rounded-md text-white bg-blue-500">All time</div>
            <div class=" text-gray-500 text-sm p-2 text-center">12 Month</div>
            <div class=" text-gray-500 text-sm p-2 text-center">30 Days</div>
            <div class=" text-gray-500 text-sm p-2 text-center">7 Days</div>
            <div class=" text-gray-500 text-sm p-2 text-center">1 Days</div>
        </div>
        <div class="grid grid-cols-1 ">
            <button class="bg-blue-500 text-sm p-3 rounded-md text-white"><i class="fa-solid fa-plus pe-2"></i>Tambah produk</button>
        </div>
    </div>
    <div class="grid w-full grid-cols-1 gap-4  sm:grid-cols-2 2xl:grid-cols-3">
        <div class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex gap-x-6 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <i class="fa-solid fa-box-open text-4xl text-gray-400"></i>
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Jumlah Produk</h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">2,340</span>
                <p class="flex items-center text-base font-normal text-gray-500 dark:text-gray-400">
                    <span class="flex items-center mr-1.5 text-sm text-green-500 dark:text-green-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z">
                            </path>
                        </svg>
                        12.5%
                    </span>
                    Since last month
                </p>
            </div>
        </div>
        <div class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex gap-x-6 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <i class="fa-solid fa-arrow-down text-4xl text-emerald-500"></i>
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Pemasukkan</h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">2,340</span>
                <p class="flex items-center text-base font-normal text-gray-500 dark:text-gray-400">
                    <span class="flex items-center mr-1.5 text-sm text-green-500 dark:text-green-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z">
                            </path>
                        </svg>
                        3,4%
                    </span>
                    Since last month
                </p>
            </div>
        </div>
        <div class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 gap-x-6 dark:bg-gray-800">
            <i class="fa-solid fa-arrow-up text-4xl text-red-500"></i>
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Pengeluaran</h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">2,340</span>
                <p class="flex items-center text-base font-normal text-gray-500 dark:text-gray-400">
                    <span class="flex items-center mr-1.5 text-sm text-green-500 dark:text-green-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z">
                            </path>
                        </svg>
                        3,4%
                    </span>
                    Since last month
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
