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
                        @if ($item->status == 'pending')
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
                                data-target-modal="transaction-{{ $item['id'] }}">
                            @else
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        @endif

                        <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white overflow-hidden">
                            {{ $item->product->name }}</td>
                        <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white truncate xl:max-w-xs">
                            {{ $item->user->name }}</td>
                        <td class="p-4 ">
                            @switch($item->type)
                                @case('in')
                                    <span
                                        class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500">
                                        <i class="fa-solid fa-arrow-down"></i>
                                        {{ $item->type }}
                                    </span>
                                @break

                                @case('out')
                                    <span
                                        class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500">
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
                            @switch($item->status)
                                @case('pending')
                                    <span
                                        class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                        <span class="w-2 h-2 me-1 bg-yellow-500 rounded-full"></span>
                                        {{ $item->status }}
                                    </span>
                                @break

                                @case('completed')
                                    <span
                                        class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                        {{ $item->status }}
                                    </span>
                                @break

                                @case('cancelled')
                                    <span
                                        class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
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
                        @if ($item->status == 'pending')
                            <div id="transaction-{{ $item['id'] }}" tabindex="-1" data-modal="close-outside"
                                class="hidden transition-all duration-500 ease-in-out fixed h-screen w-full z-50 top-0 right-0 flex items-center justify-center bg-gray-800 bg-opacity-0">
                                <div class="relative w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 animationDrop"
                                        data-modal="body">

                                        <!-- Modal body -->
                                        <div data-modal="body">
                                            <div class="flex justify-between w-full p-2 px-4">
                                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-400">Stock
                                                    Confirmation</h3>
                                                <button type="button"
                                                    data-hide-modal="transaction-{{ $item['id'] }}"
                                                    class="text-gray-200">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>

                                            <div
                                                class="p-2 px-4 text-gray-800 dark:text-gray-400 divide-y dark:divide-gray-600">
                                                <div class="pb-2  font-medium">Transaction Details</div>
                                                <div class="py-2">
                                                    <div class="flex justify-between mb-3">
                                                        <div class="">Product name :</div>
                                                        <span
                                                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs bg-gray-100 text-gray-800 dark:bg-gray-800/30 dark:text-gray-500">
                                                            {{ $item->product->name }}
                                                        </span>
                                                    </div>
                                                    <div class="flex justify-between mb-3">
                                                        <div class="text-base">Type :</div>
                                                        @switch($item->type)
                                                            @case('in')
                                                                <span
                                                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500">
                                                                    <i class="fa-solid fa-arrow-down"></i>
                                                                    {{ $item->type }}
                                                                </span>
                                                            @break

                                                            @case('out')
                                                                <span
                                                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500">
                                                                    <i class="fa-solid fa-arrow-up"></i>
                                                                    {{ $item->type }}
                                                                </span>
                                                            @break

                                                            @default
                                                        @endswitch

                                                    </div>
                                                    <div class="flex justify-between mb-3">
                                                        <div class="text-base">Status :</div>
                                                        @switch($item->status)
                                                            @case('pending')
                                                                <span
                                                                    class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                                                    <span
                                                                        class="w-2 h-2 me-1 bg-yellow-500 rounded-full"></span>
                                                                    {{ $item->status }}
                                                                </span>
                                                            @break

                                                            @case('completed')
                                                                <span
                                                                    class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                                    {{ $item->status }}
                                                                </span>
                                                            @break

                                                            @case('cancelled')
                                                                <span
                                                                    class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                                    <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                                    {{ $item->status }}
                                                                </span>
                                                            @break

                                                            @default
                                                        @endswitch
                                                    </div>
                                                    <div class="flex justify-between mb-3">
                                                        <div class="text-base">Quantity :</div>
                                                        <span
                                                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800/30 dark:text-gray-500">
                                                            {{ $item->quantity }}
                                                        </span>
                                                    </div>
                                                    <div class="flex justify-between mb-3">
                                                        <div class="text-base">User :</div>
                                                        <span
                                                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800/30 dark:text-gray-500">
                                                            {{ $item->user->name }}
                                                        </span>
                                                    </div>
                                                    <div class="flex justify-between mb-3">
                                                        <div class="text-base">Date :</div>
                                                        <span
                                                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800/30 dark:text-gray-500">
                                                            {{ $item->date }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class=" py-2 font-medium">
                                                    <h3
                                                        class="font-normal text-base text-gray-800 dark:text-gray-400 mb-2">
                                                        Notes</h3>
                                                    <textarea rows="4"
                                                        class="block p-2.5 w-full text-sm text-left text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        readonly>{{ $item->notes }}</textarea>
                                                </div>
                                            </div>
                                            <div class="flex justify-end border-t dark:border-gray-600 p-2 py-3 gap-1">
                                                <form action="{{ route('reject_transaction',$item->id) }}" method="post" data-form="reject">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-4 py-2 text-sm font-medium focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                        Reject
                                                    </button>
                                                </form>
                                                <form action="{{ route('confirm_transation',$item->id) }}" method="post" data-form="accept">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-4 py-2 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                        accept
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                        <!-- Modal footer -->

                                    </div>
                                </div>
                            </div>
                        @endif
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
