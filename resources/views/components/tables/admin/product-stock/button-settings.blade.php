@props(['route' => null, 'item'])
<button type="button" data-target-modal="product-stock-setting-{{ $item['product_id'] }}"
    id="setting-product-stock-{{ $item['product_id'] }}"
    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-800 dark:text-gray-400 hover:text-gray-500 dark:hover:text-gray-100 rounded-lg">
    <i class="fa-solid fa-gear"></i>
</button>
<div class="hidden transition-all duration-500 ease-in-out fixed h-screen w-full z-50 top-0 right-0 flex items-center justify-center bg-gray-800 bg-opacity-0"
    tabindex="-1" id="product-stock-setting-{{ $item['product_id'] }}">
    <div class="relative p-4 w-full max-w-md max-h-full">

        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 p-4 animationDrop" data-modal="body">
            <div class="flex justify-between border-b">
                <h2 class="text-xl font-semibold mb-3 text-gray-700 dark:text-gray-50">
                    Item Setting
                </h2>
                <button data-hide-modal="product-stock-setting-{{ $item['product_id'] }}"
                    class="absolute right-4 top-4"><i class="fa-solid fa-x text-gray-400"></i></button>
            </div>
            {{-- <div class="text-left my-4">
                <label for="minimal_stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Minimal
                    Stock</label>
                <input type="text" data-input-minimum-stock="{{ $item['product_id'] }}" name="minimal_stock"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    data-stock-current="{{ $item['minimal_stock'] }}" value="{{ $item['minimal_stock'] }}">
            </div>
            <div class="flex justify-end gap-1">
                <div class="">
                    <button class="button-delete end"
                        data-hide-modal="product-stock-setting-{{ $item['product_id'] }}">cancel</button>
                </div>
                <div class="">
                    <button class="button-delete end" data-save-minimum-stock="{{ $item['product_id'] }}"
                        disabled>Save</button>
                </div>
            </div> --}}

        </div>
        
    </div>
</div>
