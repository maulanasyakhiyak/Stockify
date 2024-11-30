@extends('layouts.admin')
@section('subtitle', 'Detail Opname ')
@section('content')
<div class="p-4 bg-gray-700">
    <div class="rounded-lg overflow-hidden border dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="">
                        <th scope="col" class="p-2">
                            Product name
                        </th>
                        <th scope="col" class="p-2">
                            Stock fisik
                        </th>
                        <th scope="col" class="p-2">
                            Stock sistem
                        </th>
                        <th scope="col" class="p-2">
                            Selisih
                        </th>
                        <th scope="col" class="p-2">
                            keterangan
                        </th>
                        
                    </tr>
                </thead>
                <tbody id="item-search-append">
                    @foreach ($data->detailOpnames as $item)    
                    <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 divide-x-2 divide-gray-200 dark:divide-gray-700">

                        <td class="p-2">
                            {{$item->product->name}}
                        </td>
                        <td class="p-2">
                            {{$item->stok_fisik}}
                        </td>
                        <td class="p-2">
                            {{$item->stok_sistem}}
                        </td>
                        <td class="p-2 {{$item->selisih < 0 ? 'text-red-500' : ($item->selisih > 0 ? 'text-green-500' : 'text-gray-500')}}">
                            {{$item->selisih}}
                        </td>
                        <td class="p-2">
                            {{$item->keterangan}}
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
