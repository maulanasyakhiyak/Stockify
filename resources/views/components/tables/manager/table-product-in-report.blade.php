@props(['barang_masuk'])

<div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="p-4 text-sm font-medium text-left text-gray-500 dark:text-gray-400">
                            Product name
                        </th>
                        <th scope="col" class="p-4 text-sm font-medium text-left text-gray-500 dark:text-gray-400">
                            User
                        </th>
                        <th scope="col" class="p-4 text-sm font-medium text-left text-gray-500 dark:text-gray-400">
                            Quantity
                        </th>
                        <th scope="col" class="p-4 text-sm font-medium text-left text-gray-500 dark:text-gray-400">
                            Type
                        </th>
                        <th scope="col" class="p-4 text-sm font-medium text-left text-gray-500 dark:text-gray-400">
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($barang_masuk as $item)
                    <tr class="text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700}}">
                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ $item->product->name }}</td>
                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ $item->user->first_name . ' ' .$item->user->last_name  }} </td>
                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ $item->quantity  }} </td>
                            <td class="py-2 px-4 text-base whitespace-nowrap"> 
                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500">
                                    <i class="fa-solid fa-arrow-down"></i>
                                    {{$item->type}}
                                </span>
                            </td>
                            <td class="py-2 px-4 text-base whitespace-nowrap"> {{ $item->date  }} </td>
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
