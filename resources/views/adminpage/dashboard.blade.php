@extends('layouts.app')

@section('subtitle', 'Dashboard')
@section('js')
    @vite(['resources/js/admin/stock-charts.js'])
@endsection
@section('content')
    <div class="grid grid-cols-1 gap-4 p-4">
        <div
            class="w-full grid grid-cols-3 p-3 rounded-lg shadow divide-x bg-white divide-gray-300 dark:bg-gray-800 dark:divide-gray-600">
            <a href="{{ route('admin.product.data-produk') }}" class="p-3 flex flex-col gap-3">
                <div class="">
                    <h3 class="text-base sm:text-lg font-medium text-gray-700 dark:text-white">Jumlah Product</h3>
                </div>
                <div class="flex items-center">
                    <i class="fa-solid fa-box text-gray-600 dark:text-gray-300 text-xl sm:text-3xl pe-4"></i>
                    <span
                        class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">{{ $total_product }}</span>
                </div>
            </a>
            <div class="p-3 flex flex-col gap-3">
                <div class="">
                    <h3 class="text-base sm:text-lg font-medium text-gray-700 dark:text-white">Transaksi Masuk</h3>
                </div>
                <div class="flex items-center">
                    <i class="fa-solid fa-down-long text-green-600 text-xl sm:text-3xl pe-4"></i>
                    <span
                        class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">{{ $total_transaksi_masuk }}</span>
                </div>
            </div>
            <div class="p-3 flex flex-col gap-3">
                <div class="">
                    <h3 class="text-base sm:text-lg font-medium text-gray-700 dark:text-white">Transaksi Keluar</h3>
                </div>
                <div class="flex items-center">
                    <i class="fa-solid fa-up-long text-red-600 text-xl sm:text-3xl pe-4"></i>
                    <span
                        class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">{{ $total_transaksi_keluar }}</span>
                </div>
            </div>
        </div>
        <div class="grid gap-4 xl:grid-cols-2 2xl:grid-cols-3">
            <!-- Main widget -->
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-shrink-0">
                        <span class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white"
                            data-chart="total">$45,385</span>
                        <h3 class="text-base font-light text-gray-500 dark:text-gray-400" data-chart="time">Sales this week
                        </h3>
                    </div>
                </div>
                <div id="stock-charts"></div>
                <!-- Card Footer -->
                <div
                    class="flex items-center justify-between pt-3 mt-4 border-t border-gray-200 sm:pt-6 dark:border-gray-700">
                    <div>
                        <button id="range-button" data-dropdown-select-target="weekly-sales-dropdown"
                            class="inline-flex items-center p-2 text-sm font-medium text-gray-500 rounded-lg hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                            type="button">
                            <span>
                            </span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="weekly-sales-dropdown">
                            <ul class="py-1" role="none">
                                <li>
                                    <div data-item-value="all-time" data-selected="true"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">All time</div>
                                </li>
                                <li>
                                    <div data-item-value="7-days"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">1 week</div>
                                </li>
                                <li>
                                    <div data-item-value="1-month"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">1 month</div>
                                </li>
                                <li>
                                    <div data-item-value="1-year"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">1 year</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.stok.riwayat-transaksi') }}"
                            class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700">
                            Stocks Report
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>


            <!--Tabs widget -->
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">User Activity
                    <button data-popover-target="popover-description" data-popover-placement="bottom-end"
                        type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg><span class="sr-only">Show information</span></button>
                </h3>
                <div data-popover id="popover-description" role="tooltip"
                    class="absolute z-10 invisible inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                    <div class="p-3 space-y-2">
                        <p>Displaying curent user activity in last 7 days</p>
                        <a href="#"
                            class="flex items-center font-medium text-primary-600 dark:text-primary-500 dark:hover:text-primary-600 hover:text-primary-700">Go to report<svg class="w-4 h-4 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
                    </div>
                    <div data-popper-arrow></div>
                </div>
                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Select tab</label>
                    <select id="tabs"
                        class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option>Statistics</option>
                        <option>Services</option>
                        <option>FAQ</option>
                    </select>
                </div>
                <div id="fullWidthTabContent"
                    class="border-t h-[34rem] overflow-y-auto border-gray-200 dark:border-gray-600">
                    <div class="pt-4" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($user_activity as $item)
                                @php
                                    $user_name = $item->user->first_name . ' ' . $item->user->last_name;
                                    $initials = implode(
                                        '',
                                        array_map(function ($name) {
                                            return strtoupper(substr($name, 0, 1));
                                        }, explode(' ', $user_name)),
                                    );

                                @endphp
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center justify-between">
                                        <div
                                            class="relative inline-flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full dark:bg-gray-600">
                                            <span
                                                class="font-medium text-gray-600 dark:text-gray-300 capitalize">{{ $initials }}</span>
                                            @if ($item->user->is_active)
                                                <span
                                                    class="bottom-0 left-7 absolute  w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                            @else
                                                <span
                                                    class="bottom-0 left-7 absolute  w-3.5 h-3.5 bg-gray-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                            @endif
                                        </div>
                                        <div class="flex items-center min-w-0 w-full overflow-hidden">
                                            <div class="ml-3 text-sm">
                                                <p class="font-medium text-gray-900 truncate dark:text-white">
                                                    {{ $user_name }} <span class="font-normal text-gray-500">{{ $item->description }} </span>
                                                </p>
                                                <p class="text-xs">{{ \Carbon\Carbon::parse($item->created)->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="hidden pt-4" id="about" role="tabpanel" aria-labelledby="about-tab">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ asset('static/images/users/neil-sims.png') }}" alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate dark:text-white">
                                            Neil Sims
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            email@flowbite.com
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        $3320
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ asset('static/images/users/bonnie-green.png') }}" alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate dark:text-white">
                                            Bonnie Green
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            email@flowbite.com
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        $2467
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ asset('/images/users/michael-gough.png') }}" alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate dark:text-white">
                                            Michael Gough
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            email@flowbite.com
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        $2235
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ asset('static/images/users/thomas-lean.png') }}" alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate dark:text-white">
                                            Thomes Lean
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            email@flowbite.com
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        $1842
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ asset('static/images/users/lana-byrd.png') }}" alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate dark:text-white">
                                            Lana Byrd
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            email@flowbite.com
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        $1044
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    @endsection
