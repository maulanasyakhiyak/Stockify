@props(['id', 'products', 'categories', 'routeUpdate', 'routeDelete'])

<div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
            <table class="w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="p-4 w-10">
                            <div class="flex items-center cursor-pointer">
                                <input id="checkbox-all-product" data-checkbox_all="true" type="checkbox"
                                    class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-product" class="sr-only">Select All</label>
                            </div>
                        </th>
                        <th scope="col"
                            class="w-20 p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Image</th>
                        <th scope="col"
                            class="w-48 p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Name</th>
                        <th scope="col"
                            class="w-44 p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Atribute</th>
                        <th scope="col"
                            class="p-4 w-36 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            SKU</th>
                        <th scope="col"
                            class="p-4 w-28 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                            Purchase Price</th>
                        <th scope="col"
                            class="p-4 w-28  text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                            Selling Price</th>
                        <th scope="col"
                            class="p-4 w-60 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Description</th>
                        <th scope="col"
                            class="p-4 w-32 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-{{ $product['id'] }}" data-checkbox_item="{{ $product['id'] }}"
                                        {{ in_array($product['id'], session('checkbox', [])) ? 'checked' : '' }}
                                        aria-describedby="checkbox-{{ $product['id'] }}" type="checkbox"
                                        class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-{{ $product['id'] }}" class="sr-only">Select
                                        {{ $product['name'] }}</label>
                                </div>
                            </td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <img src="{{ asset('images/thumbnails/' . ($product['image'] ?? 'default.png')) }}"
                                    class="h-[50px] min-w-[50px] rounded-lg object-cover border" alt="Product Image"
                                    loading="lazy">
                            </td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="text-base font-semibold">{{ $product['name'] }}</div>
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    @if (!$product->category || is_null($product->category->name))
                                        <span class="text-red-500">tidak ada kategori</span>
                                    @else
                                        {{ $product->category->name }}
                                    @endif
                                </div>
                            </td>
                            <td class="sm:text-xs md:text-sm text-gray-900 dark:text-white">
                                <div class="flex h-full w-full gap-2 flex-wrap">
                                    @if ($product->attributes)
                                        @forelse ($product->attributes as $item)
                                            <div data-tooltip-target="{{ $item->name.$item->id }}" data-tooltip-placement="bottom" class="bg-sky-300 rounded p-1">{{$item->name}}</div>
                                            <div id="{{ $item->name.$item->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                {{ $item->value }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                            @empty
                                            <div class="border border-gray-400 rounded p-1">Belum ada atribut</div>
                                        @endforelse
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $product['sku'] }}</td>
                            <td
                                class="p-4 text-base font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $product['purchase_price'] }}</td>
                            <td
                                class="p-4 text-base font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $product['selling_price'] }}</td>
                            <td
                                class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">
                                {{ $product['description'] }}</td>
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <x-tables.admin.product.button-update :id="$product['id']" :target="$product['id']"
                                    :item="$product['name']" :routeUpdate="$routeUpdate" :product="$product" :categories="$categories" />
                                <x-tables.admin.product.button-delete :id="$product['id']" :target="$product['id']"
                                    :item="$product['name']" :routeDelete="$routeDelete" />
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
