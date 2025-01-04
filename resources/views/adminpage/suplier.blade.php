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
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Suppliers</h1>
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
                        <button type="button" id="drawer-add-supplier-button"
                            data-drawer-target="drawer-add-supllier"
                            data-drawer-show="drawer-add-supllier"
                            aria-controls="drawer-add-supllier" data-drawer-placement="right"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Add Supplier
                            </svg>
                        </button>
                        <!-- Edit Product Drawer -->
                        <div id="drawer-add-supllier"
                            class="fixed top-0 right-0 z-40 w-full text-left h-screen cursor-auto max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
                            tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
                            <h5 id="drawer-label"
                                class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
                                Update Product</h5>
                            <button type="button" data-drawer-dismiss="drawer-add-supllier"
                                aria-controls="drawer-add-supllier"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close menu</span>
                            </button>
                            <form action="{{ route('admin.supplier.store') }}" method="POST" class="overflow-x-auto h-5/6">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                        <input type="text" name="name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Type product name" value="{{old('name')}}">
                                    </div>
                                    <div>
                                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="text" name="email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Type product email" value="{{old('email')}}">
                                    </div>
                                    <div>
                                        <label for="phone"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                                        <input type="text" name="phone" data-input="phone-mask"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            value="{{ old('phone') }}">
                                    </div>
                        
                                    <div>
                                        <label for="address"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                        <textarea rows="4" name="address"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Enter event address here" >{{old('address')}}</textarea>
                                    </div>
                        
                                </div>
                                <div class="bottom-0 left-0 flex justify-center w-full pb-4 mt-4 space-x-4 sm:absolute sm:px-4 sm:mt-0">
                                    <button type="submit"
                                        class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        Submit
                                    </button>
                                    <button type="button" type="button" data-drawer-dismiss="drawer-add-supllier"
                                        class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <x-tables.admin.suppliers.table-suppliers :suppliers="$suppliers" />
            </div>
        </div>  

    </div>
@endsection
