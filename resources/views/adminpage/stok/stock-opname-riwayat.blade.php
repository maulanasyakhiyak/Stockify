@extends('adminpage.stok.stock-opname')



@section('content-opname')
    <div id="riwayat-opname" class="mt-8">
        <div class="rounded-lg overflow-hidden border dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="w-full">
                            <th scope="col" class="p-2 w-72">
                                Notes
                            </th>
                            <th scope="col" class="p-2 w-40">
                                User
                            </th>
                            <th scope="col" class="p-2 w-40">
                                Date
                            </th>
                            <th scope="col" class="p-2">
                                Url
                            </th>

                        </tr>
                    </thead>
                    <tbody id="item-search-append">
                        @foreach ($riwayat as $item)
                            <tr
                                class="bg-white dark:bg-gray-800 dark:border-gray-700 divide-x-2 divide-gray-200 dark:divide-gray-700">

                                <td class="p-2">
                                    {{ $item->user->name }}
                                </td>
                                <td class="p-2">
                                    {{ $item->user->name }}
                                </td>
                                <td class="p-2">
                                    {{ $item->tanggal_opname }}
                                </td>
                                <td class="p-2 whitespace-nowrap truncate overflow-hidden">
                                    <a target="_blank" href="{{ route('admin.stok.productStok.Detailopname', $item->token) }}">{{ route('admin.stok.productStok.Detailopname', $item->token) }}</a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
