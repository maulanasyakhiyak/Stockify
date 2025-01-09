@props(['productStock'])

<div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Product name
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Stock
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Minimal Stock
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Stock updated
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($productStock as $item)
                    <tr class="{{ $item->minimal_stock >= $item->stock  && $item['updated_at'] ? ' hover:bg-red-50 dark:hover:bg-gray-700' : 'text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">

                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ $item->product->name  }}</td>
                            <td class="py-2 px-4 text-base whitespace-nowrap {{ $item->minimal_stock >= $item->stock  && $item['updated_at'] ? 'text-red-500' : ''}}"> {{ $item->stock  }} </td>
                            <td class="py-2 px-4 text-base whitespace-nowrap"> 
                                <div class="relative border rounded w-24 flex justify-between items-center text-gray-900 dark:text-gray-400 dark:border-gray-500">
                                    <input type="text" data-minimal-stock="{{$item->product_id}}" name="new_minimal_stock" data-max-input="{{ $item->stock  }}" class="px-2 bg-transparent p-0 border-0 w-16 ring-0 focus:ring-0" value="{{ $item->minimal_stock  }}" inputmode="numeric" pattern="[0-9]*">
                                    <form action="{{ route('admin.stok.productStok.update-minimum-stock', $item->product_id) }}" class="inline" method="post" id="update-minimal-stock-{{$item->product_id}}">
                                        @csrf
                                        <button type="submit" disabled id="button-minimal-stock-{{$item->product_id}}" class="bg-green-300 dark:bg-green-500 dark:disabled:bg-gray-500 disabled:bg-green-100 px-2 rounded-e">
                                            <i class="fa-solid fa-check  text-sm text-white dark:text-gray-300"></i>
                                        </button>  
                                    </form>
                                </div>     
                            </td>
                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ Carbon\Carbon::parse($item->updated_at)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center text-gray-500 dark:text-gray-400">No products
                                found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="p-4 border-t dark:border-gray-500">
    {{ $productStock->links() }}
</div>
