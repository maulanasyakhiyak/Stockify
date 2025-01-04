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
                            SKU
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Stok
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Minimal stok
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Stock updated
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($productStock as $item)
                    <tr class="text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ $item['product_name']  }}</td>
                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ $item['sku']  }} </td>
                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ $item['stock_akhir']  }} </td>
                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ $item['minimal_stock']  }} </td>
                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ $item['updated_at'] ? $item['updated_at']  : 'null'  }} </td>
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
