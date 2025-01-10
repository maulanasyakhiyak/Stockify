@extends('layouts.app')

@section('subtitle', 'Dashboard')
@section('content')
    <div class="flex h-[625px] gap-4 p-4">
        <!-- Card 1 -->
        <div class="flex flex-col border rounded-xl shadow bg-white dark:bg-gray-800 dark:border-gray-600 p-4 w-1/2">
            <div class="text-gray-500 dark:text-gray-200 text-lg mb-4">
                <i class="fa-solid fa-box-open pe-2 text-red-500"></i>Low Stock
            </div>
            <div class="">
                <table class="w-full table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 bg-transparent dark:text-gray-400 border-b dark:border-gray-700">
                        <tr>
                            <th scope="col" class="w-3/5 pb-2 text-sm font-medium text-gray-400">
                                Name
                            </th>
                            <th scope="col" class="pb-2 w-1/5 text-center text-sm font-medium text-gray-400">
                                Current
                            </th>
                            <th scope="col" class="pb-2 w-1/5 text-center text-sm font-medium text-gray-400">
                                Minimal
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="overflow-y-auto scrollbar-hidden max-h-[470px]">
                <table class="table-auto w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <tbody>
                        @forelse ($low_stock as $item)
                        <tr class="bg-transparent border-b dark:border-gray-700">
                            <td class="py-4 w-3/5 font-semibold text-gray-900 dark:text-gray-200">
                                <div class="flex items-center gap-2">
                                    <span class="inline-block h-4 w-4 rounded-md bg-red-400"></span>
                                    <div class="text-red-00">{{$item->product->name}}</div>
                                </div>
                            </td>
                            <td class="py-4 w-1/5 font-semibold text-gray-900 dark:text-gray-200 text-center">
                                {{$item->stock}}
                            </td>
                            <td class="py-4 w-1/5 font-semibold text-gray-900 dark:text-gray-200 text-center">
                                {{$item->minimal_stock}}
                            </td>
                        </tr>
                        @empty
                            <tr class="bg-transparent border-b dark:border-gray-700">
                                <td colspan="3" class="text-center text-gray-300">No data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    
        <!-- Card 2 and Card 3 -->
        <div class="flex flex-col gap-4 flex-grow">
            <!-- Card 2 -->
            <div class="flex border rounded-xl shadow bg-white dark:bg-gray-800 dark:border-gray-600  p-4 h-1/2 flex-col">
                <div class="text-gray-500 dark:text-gray-200 text-lg mb-4">
                    <i class="fa-solid fa-arrow-down pe-2 text-green-500"></i> Items Received Today
                </div>
                <div class="flex flex-col overflow-y-auto scrollbar-hidden gap-3" style="max-height: 200px;">
                    @forelse ($receive_today as $item)
                        <div class="bg-green-400 rounded-lg p-2 px-4 w-full flex justify-between text-white">
                            <div class="flex items-center gap-2 font-normal ">
                                <span class="inline-block h-2 w-2 bg-white rounded-full"></span>
                                <h1>{{$item->product->name}}</h1>
                            </div>
                            <div class="font-semibold">{{$item->quantity}} pcs</div>
                        </div>
                    @empty
                        <div class="bg-transparent mt-20">
                            <div class="text-center text-gray-300 w-full">No data</div>
                        </div>
                    @endforelse
                    
                </div>
            </div>
            <!-- Card 3 -->
            <div class="flex border rounded-xl shadow bg-white dark:bg-gray-800 dark:border-gray-600  p-4 h-1/2 flex-col">
                <div class="text-gray-500 dark:text-gray-200 text-lg mb-4 ">
                    <i class="fa-solid fa-arrow-up pe-2 text-red-500"></i> 
                    Items Dispatched Today
                </div>
                <div class="flex flex-col overflow-y-auto scrollbar-hidden gap-3" style="max-height: 200px;">
                    @forelse ($dispatched_today as $item)
                    <div class="bg-red-400 rounded-lg p-2 px-4 w-full flex justify-between text-white">
                        <div class="flex items-center gap-2 font-normal ">
                            <span class="inline-block h-2 w-2 bg-white rounded-full"></span>
                            <h1>{{$item->product->name}}</h1>
                        </div>
                        <div class="font-semibold">{{$item->quantity}} pcs</div>
                    </div>
                @empty
                    <div class="bg-transparent mt-20">
                        <div class="text-center text-gray-300 w-full">No data</div>
                    </div>
                @endforelse
                </div>
            </div>
        </div>
    </div>
    
@endsection
