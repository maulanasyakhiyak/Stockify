@extends('layouts.app')

@section('subtitle', 'Stok')

@section('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    @vite(['resources/js/staff/stock.js'])
@endsection
@section('other_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

{{-- cek filter --}}
@php
    $allNull = empty(array_filter($filter, function ($value) {
        return !is_null($value);
    }));
@endphp

@section('content')

<div class="grid grid-cols-1 gap-4 p-4">
    <div class="flex flex-col">
        <div class="mb-4 flex justify-between">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Data products</h1>
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
                            <form action="{{ route('admin.stok.riwayat-transaksi') }}" method="GET" class="inline">
                                <input type="text" id="simple-search" name="search"
                                    class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search">
                            </form>
                        </div>
                    </form>
                </div>
                <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                    <div class="flex items-center w-full space-x-3 md:w-auto">
                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                            data-dropdown-ignore-click-outside-class="ignore-dropdown"
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium {{ $allNull ? 'text-gray-900 border-gray-200 dark:text-gray-400 dark:border-gray-600' : 'text-primary-700 border-primary-700 dark:text-primary-300' }} bg-white border rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                            type="button">
                            <i class="fa-solid fa-filter pe-2"></i>
                            Filter
                            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="filterDropdown" class="z-10 hidden p-3 w-72 bg-white rounded-lg shadow border dark:border-gray-600 dark:bg-gray-700">
                            <div class="flex flex-col gap-2">
                                <div class="flex justify-between text-gray-900 dark:text-gray-50">
                                    <h3 class="p-2 text-gray-900 dark:text-gray-50 font-semibold">Filter</h3>
                                    <div class="p-2 flex gap-4 text-sm">
                                        <button id="applyFilter" class="hover:underline ">Apply</button>
                                        <form action="{{ route('admin.stok.filter.clear',['route'=> Request::path()]) }}" class="inline"
                                            method="POST">
                                            <button type="submit" class="hover:underline ">Clear all</button>
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                fill="currentColor" viewbox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="text" id="simple-search-filter" name="search" value="{{ $filter['search'] }}" data-search-result-target="target"
                                        class="ignore-dropdown block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Search product">
                                        <ul id="target" class="w-full rounded-lg hidden absolute border shadow-sm overflow-hidden dark:border-gray-600" style=""></ul>
                                    </div>
                                </div>
                                <div class="">
                                    <button type="button" data-filter-collapse="filter-status"
                                        class="text-sm flex items-center justify-between w-full p-2 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl dark:border-gray-600 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3">
                                        Status
                                    </button>
                                    <div class="hidden p-2 border border-b-0 dark:border-gray-600" id="filter-status"
                                        data-hidden="true">
                                        <ul class="space-y-3 text-sm text-gray-700 dark:text-gray-200"
                                            aria-labelledby="filter-status">
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="checkbox-item-1"
                                                        {{ isset($filter['status']) && in_array('completed', $filter['status']) ? 'checked' : '' }}
                                                        type="checkbox" name="completed" value="1"
                                                        data-checkbox="status"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="checkbox-item-1"
                                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                        Completed
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="checkbox-item-2"
                                                        {{ isset($filter['status']) && in_array('pending', $filter['status']) ? 'checked' : '' }}
                                                        type="checkbox" name="pending" value="1"
                                                        data-checkbox="status"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="checkbox-item-2"
                                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                        Pending
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="checkbox-item-3"
                                                        {{ isset($filter['status']) && in_array('cancelled', $filter['status']) ? 'checked' : '' }}
                                                        type="checkbox" name="cancelled" value="1"
                                                        data-checkbox="status"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="checkbox-item-3"
                                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                        Canceled
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <button type="button" data-filter-collapse="filter-type"
                                        class="text-sm flex items-center justify-between w-full p-2 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 dark:border-gray-600 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3">Type</button>
                                    <div class="hidden p-2 border dark:border-gray-600" id="filter-type"
                                        data-hidden="true">
                                        <ul class="space-y-3 text-sm text-gray-700 dark:text-gray-200"
                                            aria-labelledby="dropdownRadioButton">
                                            <li>
                                                <div class="flex items-center">
                                                    <input checked id="default-radio-1" type="radio" value=""
                                                        name="default-radio"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="default-radio-1"
                                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">All</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="default-radio-2" type="radio" value="in"
                                                        name="default-radio"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="default-radio-2"
                                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">In</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="flex items-center">
                                                    <input id="default-radio-3" type="radio" value="out"
                                                        name="default-radio"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="default-radio-3"
                                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Out</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <button type="button" data-filter-collapse="filter-date"
                                        class="text-sm flex items-center justify-between w-full p-2 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 dark:border-gray-600 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3">Date
                                        range</button>
                                    <div class="hidden p-2 border dark:border-gray-600" id="filter-date"
                                        data-hidden="true">
                                        <div class="flex flex-col items-center">
                                            <div class="relative w-full">
                                                <div
                                                    class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                    </svg>
                                                </div>
                                                <input id="datepicker-start" name="start-date-filter" type="text"
                                                    data-start-date="{{ $earliestDate }}"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Select date start" readonly>
                                            </div>
                                            <span class="my-2 text-gray-500">to</span>
                                            <div class="w-full relative">
                                                <div
                                                    class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                    </svg>
                                                </div>
                                                <input id="datepicker-end" name="end-date-filter" type="text"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Select date end" readonly>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="button" data-filter-collapse="filter-type3"
                                        class="text-sm flex items-center justify-between w-full p-2 font-medium rtl:text-right text-gray-500 border border-gray-200 dark:border-gray-600 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3">Collapse</button>
                                    <div class="hidden p-2 border dark:border-gray-600" id="filter-type3"
                                        data-hidden="true">
                                        asdadasdad
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <x-tables.staff.table-stock-transaction :stockTransaction="$stockTransaction" />
        </div>
    </div>
</div>

@endsection
