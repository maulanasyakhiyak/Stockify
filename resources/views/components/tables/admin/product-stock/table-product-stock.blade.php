@props(['productStock'])

<div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Product name
                        </th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            SKU
                        </th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Stok
                        </th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Updated
                        </th>
                        <th scope="col"
                            class="w-20 text-center p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($productStock as $item)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">

                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{ $item['product_name']  }}</td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{ $item['sku']  }} </td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{ $item['stock_akhir']  }} </td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{ $item['updated_at']  }} </td>
                            <td class="p-4 text-center text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"> 
                                <x-tables.admin.product-stock.button-settings :item="$item" />
                            </td>
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

<div class="flex">
    {{ $productStock->links() }}
</div>
