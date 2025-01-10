@extends('layouts.app')
@section('js')
    @vite(['resources/js/manager/laporan.js'])
@endsection
@section('subtitle', 'Laporan')
@section('content')
    <div class="relative flex flex-col p-4 overflow-visible min-h-96">
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Laporan</h1>
        </div>
        <div class="grid grid-cols-1 gap-y-4 divide-gray-900">
            <div class="bg-white shadow dark:bg-gray-800 sm:rounded-lg overflow-hidden pb-2">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <div class="">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Product Stock</h2>
                        <div class="flex gap-2 {{$data_filter['category'] || $data_filter['period'] ? 'mb-1' : ''}}">
                            @if ($data_filter['category'])
                                <span class="max-w-40 truncate whitespace-nowrap inline-block py-1 px-2 rounded-lg text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">Category : {{$data_filter['category']}}</span>
                            @endif
                            @if($data_filter['period'])
                                <span class="inline-block py-1 px-2 rounded-lg text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">Periode : {{$data_filter['period']}}</span>                    
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-1">

                        <button id="dropdown-filter-stock-button" data-dropdown-toggle="dropdown-filter-stock"
                            data-dropdown-ignore-click-outside-class="datepicker"
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400"
                                viewbox="0 0 20 20" fill="currentColor">
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
                        <!-- Dropdown menu -->
                        <form action="{{ route('manager.laporan.filter') }}" class="inline" method="POST">
                            @csrf
                            <div id="dropdown-filter-stock"
                                class="z-10 hidden bg-white divide-y-2  divide-gray-200 dark:divide-gray-600 rounded-lg border border-gray-300 text-gray-600 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                <div class="text-sm p-2 font-semibold ">Filter</div>
                                <div class="p-2">
                                    <div class="flex justify-between mb-2">
                                        <h1 class="text-sm font-semibold">Periode</h1>
                                        <button type="button" id="reset_period" class="font-normal text-sm">Reset</button>
                                    </div>
                                    <div id="date-range-picker" class="flex items-center gap-1">
                                        <div class="relative">
                                            <label for=""
                                                class="text-xs text-gray-500 dark:text-gray-200 font-medium">From :</label>
                                            <input autocomplete="off" id="datepicker-range-stock-start" name="start" readonly
                                                type="text" data-input-date="start" value="{{$data_filter['date_start'] ?? ''}}"
                                                class="bg-gray-50 border cursor-pointer mt-1 p-1 border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-32 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Select date start">
                                        </div>
                                        <div class="relative">
                                            <label for=""
                                                class="text-xs text-gray-500 dark:text-gray-200 font-medium">To :</label>
                                            <input autocomplete="off" id="datepicker-range-stock-end" name="end" readonly
                                                type="text" data-input-date="end" value="{{$data_filter['date_end'] ?? ''}}"
                                                class="bg-gray-50 border cursor-pointer mt-1 p-1 border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-32  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Select date end">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <h1 class="text-sm mb-1 font-semibold">Category</h1>
                                    <select id="category" name="category"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-gray-500 focus:border-gray-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                            <option selected value="" hidden>Pilih kategori</option>
                                        @forelse ($category as $item )
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @empty
                                            <option value="">Tidak ada kategori</option>
                                        @endforelse
                                    </select>

                                </div>
                                <div class="p-2 flex justify-end">
                                    <button type="submit"
                                        class="w-full text-sm bg-green-400 rounded px-2 py-1 text-white hover:bg-green-500 transition duration-200 ease-in-out">
                                        Apply now
                                    </button>
                                </div>
                            </div>

                        </form>
                        <a href="{{ route('admin.laporan.ExportProductStock') }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text
                            text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm focus:outline-none
                            focus:ring-2 focus:ring-offset-2
                            focus:ring-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus
                            ring-blue-600 dark:focus:ring-blue-700">
                            Export CSV
                        </a>
                    </div>
                </div>
                <x-tables.manager.table-product-stock-report :productStock="$laporanStock" />
            </div>
            <div class="bg-white shadow dark:bg-gray-800 sm:rounded-lg overflow-hidden pb-2">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <div class="">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Barang Masuk</h2>
                    </div>
                    
                    <div class="flex items-center gap-1">
                        <a href="{{ route('manager.laporan.export_in') }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text
                            text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm focus:outline-none
                            focus:ring-2 focus:ring-offset-2
                            focus:ring-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus
                            ring-blue-600 dark:focus:ring-blue-700">
                            Export CSV
                        </a>
                    </div>
                </div>
                <x-tables.manager.table-product-in-report :barang_masuk="$barang_masuk" />
            </div>
            <div class="bg-white shadow dark:bg-gray-800 sm:rounded-lg overflow-hidden pb-2">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <div class="">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Barang Keluar</h2>
                    </div>
                    
                    <div class="flex items-center gap-1">
                        <a href="{{ route('manager.laporan.export_out') }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text
                            text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm focus:outline-none
                            focus:ring-2 focus:ring-offset-2
                            focus:ring-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus
                            ring-blue-600 dark:focus:ring-blue-700">
                            Export CSV
                        </a>
                    </div>
                </div>
                <x-tables.manager.table-product-out-report :barang_keluar="$barang_keluar" />
            </div>
        </div>
    </div>
@endsection
</svg>
</button>

<div id="dateRangeDropdown"
    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-80 lg:w-96 dark:bg-gray-700 dark:divide-gray-600">
    <div class="p-3" aria-labelledby="dateRangeButton">
        <div date-rangepicker datepicker-autohide class="flex items-center">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input name="start" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Start date">
            </div>
            <span class="mx-2 text-gray-500 dark:text-gray-400">to</span>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input name="end" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="End date">
            </div>
        </div>
    </div>
</div>
