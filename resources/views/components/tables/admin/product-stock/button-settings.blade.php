@props(['route' => null, 'item'])
<button type="button" data-target-modal="product-stock-setting-{{ $item['id'] }}"
    id="setting-product-stock-{{ $item['id'] }}"
    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-800 dark:text-gray-400 hover:text-gray-500 dark:hover:text-gray-100 rounded-lg">
    <i class="fa-solid fa-gear"></i>
</button>
<div class="hidden transition-all duration-500 ease-in-out fixed h-screen w-full z-50 top-0 right-0 flex items-center justify-center bg-gray-800 bg-opacity-0"
    tabindex="-1" id="product-stock-setting-{{ $item['id'] }}">
    <div class="relative p-4 w-full max-w-md max-h-full">

        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 p-4 animationDrop" data-modal="body">
            <div class="flex justify-between border-b">
                <h2 class="text-xl font-semibold mb-3 text-gray-700 dark:text-gray-50">
                    Item Setting
                </h2>
                <button data-hide-modal="product-stock-setting-{{ $item['id'] }}" class="absolute right-4 top-4"><i
                        class="fa-solid fa-x text-gray-400"></i></button>
            </div>
            <div class="grid grid-cols-3 text-left gap-x-2 pt-4 mb-4">
                <div class="flex justify-between items-center">
                    Minimum stok
                    <span>:</span>
                </div>
                <div class=" col-span-2">
                    <input type="text" data-input-minimum-stock="{{$item['id']}}" class="p-1 rounded w-full border-0 focus:ring-0" data-stock-current="0">
                </div>
            </div>
            <div class="flex justify-end gap-1">
                <div class="">
                    <button class="button-delete end" data-hide-modal="product-stock-setting-{{ $item['id'] }}">cancel</button>
                </div>
                <div class="">
                    <button class="button-delete end" id="button-save-minimum" disabled>Save</button>
                </div>
            </div>

        </div>
    </div>
