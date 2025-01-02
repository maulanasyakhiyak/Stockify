@props(['stockTransaction'])

<div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
            <table class="w-full divide-y divide-gray-200 table-auto dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Product Name</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            User</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            type</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                            Qty</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Date</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Status</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($stockTransaction as $item)
                    
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white overflow-hidden">
                                {{ $item->product->name }}</td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white truncate xl:max-w-xs">
                                {{ $item->user->first_name }} {{ $item->user->last_name }}</td>
                            <td class="p-4 ">
                                @switch($item->type)
                                    @case('in')
                                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500">
                                        <i class="fa-solid fa-arrow-down"></i>
                                        {{$item->type}}
                                    </span>

                                    @break
                                    @case('out')
                                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500">
                                        <i class="fa-solid fa-arrow-up"></i>
                                        {{ $item->type }}
                                    </span>
                                        @break
                                    @default

                                @endswitch
                            </td>
                            <td
                                class="p-4 text-center text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->quantity }}</td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->date }}</td>
                            <td class="p-4 ">
                                @switch($item->status )
                                    @case('pending')
                                    <span class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                        <span class="w-2 h-2 me-1 bg-yellow-500 rounded-full"></span>
                                        {{ $item->status }}
                                    </span>
                                        @break
                                    @case('completed')
                                    <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                        {{ $item->status }}
                                    </span>
                                        @break
                                    @case('cancelled')
                                    <span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                        <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                        {{ $item->status }}
                                    </span>
                                        @break
                                    @default

                                @endswitch
                            </td>
                            <td
                                class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">
                                {{ $item->notes }}</td>
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
