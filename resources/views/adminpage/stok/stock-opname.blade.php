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

        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 mt-3">
            <ul class="flex flex-wrap -mb-px">

                <li class="me-2">
                    <a href="{{ route('admin.stok.productStok.opname-manual') }}"
                        class="inline-block cursor-pointer p-4 border-b-2 rounded-t-lg
                        {{request()->routeIs('admin.stok.productStok.opname-manual') ? 'text-blue-600  border-blue-600 dark:text-blue-500 dark:border-blue-500' 
                        : ' hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} ">
                        Manual</a>
                </li>
                <li class="me-2">
                    <a href="{{ route('admin.stok.productStok.opname-withcsv') }}"
                    class="inline-block cursor-pointer p-4 border-b-2 rounded-t-lg
                    {{request()->routeIs('admin.stok.productStok.opname-withcsv') ? 'text-blue-600  border-blue-600 dark:text-blue-500 dark:border-blue-500' 
                    : ' hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} "
                        aria-current="page">With CSV</a>
                </li>
                <li class="me-2">
                    <a href="{{ route('admin.stok.productStok.opname-riwayat') }}"
                    class="inline-block cursor-pointer p-4 border-b-2 rounded-t-lg
                    {{request()->routeIs('admin.stok.productStok.opname-riwayat') ? 'text-blue-600  border-blue-600 dark:text-blue-500 dark:border-blue-500' 
                    : ' hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} "
                        aria-current="page">Riwayat</a>
                </li>

            </ul>
        </div>

        @yield('content-opname')

    </div>
@endsection
