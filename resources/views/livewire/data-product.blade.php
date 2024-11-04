<div class="grid grid-cols-1 gap-4 p-4">
    <div class="flex flex-col">
        <div class="block sm:flex items-center rounded-t-lg justify-between mb-3 lg:mt-1.5">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Data products</h1>
                </div>

                <div class="items-center justify-between block sm:flex dark:divide-gray-700">
                    <div class="md:flex items-center mb-4 hidden sm:mb-0">

                        <div class="flex items-center w-full sm:justify-end">
                            <div class="flex gap-3">
                                <div class="selected-info text-gray-500 dark:text-gray-300 hidden">0 data selected</div>

                                <button data-tooltip-target="export-button" data-tooltip-placement="bottom"
                                    type="button"
                                    class="rounded-lg border text-gray-500 dark:text-gray-50 bg-white dark:bg-gray-700 dark:border-gray-500  text-sm p-3">
                                    <i class="fa-solid fa-file-arrow-up pe-2"></i>Export
                                </button>

                                <button data-tooltip-target="import-bottom" data-tooltip-placement="bottom"
                                    type="button"
                                    class="rounded-lg border text-gray-500 dark:text-gray-50 bg-white dark:bg-gray-700 dark:border-gray-500  text-sm p-3">
                                    <i class="fa-solid fa-file-arrow-down pe-2"></i>Import
                                </button>

                                <div id="import-bottom" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-700 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-600">
                                    Import file
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <div id="export-button" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-700 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-600">
                                    Export file
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <button data-tooltip-target="delete-button" data-tooltip-placement="bottom"
                                    type="button" class="bg-red-500 rounded-lg text-white text-sm p-3">
                                    <i class="fa-solid fa-trash-can pe-2"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <label for="products-search" class="sr-only">Search</label>
                        <div class="relative w-48 sm:w-64 xl:w-72">
                            <input type="text" name="email" id="products-search"
                                class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search products by name">
                        </div>

                        <button id="createProductButton"
                            class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
                            type="button" data-drawer-target="drawer-create-product-default"
                            data-drawer-show="drawer-create-product-default"
                            aria-controls="drawer-create-product-default" data-drawer-placement="right">
                            <i class="fa-solid fa-plus pe-2"></i>New product
                        </button>

                    </div>

                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"
                                            class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Name
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Image
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Stock
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    purchase
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Selling
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Description
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($products as $product)

                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-{{ $product['id'] }}"
                                                aria-describedby="checkbox-{{ $product['image'] }}" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <img src="{{ $product['image'] }}"
                                            class="h-24 w-24 rounded-lg object-cover border" alt="Product Image"
                                            loading="lazy">
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">
                                            {{ $product['name'] }}</div>
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            @if (!$product->category || is_null($product->category->name))
                                                <span class="text-red-500">tidak ada kategori</span>
                                            @else
                                                {{ $product->category->name }}
                                            @endif
                                        </div>
                                    </td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $product['sku'] }} </td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $product['purchase_price'] }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        $ {{ $product['selling_price'] }}</td>
                                    <td
                                        class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">
                                        {{ $product['description'] }} </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap">

                                        <button type="button" id="drawer-update-product-{{ $product['id'] }}"
                                            data-drawer-target="drawer-update-product-default-{{ $product['id'] }}"
                                            data-drawer-show="drawer-update-product-default-{{ $product['id'] }}"
                                            aria-controls="drawer-update-product-default-{{ $product['id'] }}"
                                            data-drawer-placement="right"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Update
                                        </button>
                                        <!-- Edit Product Drawer -->
                                        <div id="drawer-update-product-default-{{ $product['id'] }}"
                                            class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
                                            tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
                                            <h5 id="drawer-label"
                                                class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
                                                Update Product</h5>
                                            <button type="button"
                                                data-drawer-dismiss="drawer-update-product-default-{{ $product['id'] }}"
                                                aria-controls="drawer-update-product-default-{{ $product['id'] }}"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close menu</span>
                                            </button>
                                            <form action="#">
                                                <div class="space-y-4">
                                                    <div>
                                                        <label for="name"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                                        <input type="text" name="title" id="name"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                            placeholder="Type product name"
                                                            value="{{ $product->name }}">
                                                    </div>
                                                    <div>
                                                        <label for="category-create"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                                        <select id="category-create" name="category"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                            <option selected hidden>Select</option>
                                                            @foreach ($categories as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ $item->id == $product->category_id ? 'selected' : '' }}>
                                                                    {{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="product_stock"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                                                        <input type="number" name="product_stock" id="product_stock"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                            placeholder="0.">
                                                    </div>
                                                    <div class="flex gap-4">
                                                        <div>
                                                            <label for="purchase_price"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purchase
                                                                price</label>
                                                            <input type="number" name="purchase_price"
                                                                id="purchase_price"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                                placeholder="Rp.">
                                                        </div>

                                                        <div>
                                                            <label for="selling_price"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selling
                                                                price</label>
                                                            <input type="number" name="selling_price"
                                                                id="selling_price"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                                placeholder="Rp.">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="description"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                                        <textarea id="description" rows="4"
                                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                            placeholder="Enter event description here"></textarea>
                                                    </div>
                                                </div>
                                                <div
                                                    class="bottom-0 left-0 flex justify-center w-full pb-4 mt-4 space-x-4 sm:absolute sm:px-4 sm:mt-0">
                                                    <button type="submit"
                                                        class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                        Update
                                                    </button>
                                                    <button type="button"
                                                        class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                        <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1"
                                                            fill="currentColor" viewBox="0 0 20 20"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <button type="button"
                                            id="deleteProductButton"
                                            data-drawer-target="drawer-delete-product-default-{{ $product['id'] }}"
                                            data-drawer-show="drawer-delete-product-default-{{ $product['id'] }}"
                                            aria-controls="drawer-delete-product-default-{{ $product['id'] }}"
                                            data-drawer-placement="right"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Delete item
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan=""></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{ $products->links() }}
    @foreach ($products as $product)
        <!-- Delete Product Drawer -->
        <div
            id="drawer-delete-product-default-{{ $product['id'] }}"
            class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
            tabindex="-1" aria-labelledby="drawer-label" aria-modal="true" role="dialog">
            <h5 id="drawer-label"
                class="inline-flex items-center text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
                Delete
                item</h5>
            <button type="button" data-drawer-dismiss="drawer-delete-product-default-{{ $product['id'] }}"
                aria-controls="drawer-delete-product-default-{{ $product['id'] }}"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
            <svg class="w-10 h-10 mt-8 mb-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mb-6 text-lg text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?
            </h3>
            <a href="#"
                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2.5 text-center mr-2 dark:focus:ring-red-900">
                Yes, I'm sure
            </a>
            <a href="#"
                class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 border border-gray-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2.5 text-center dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                data-drawer-hide="drawer-delete-product-default-{{ $product['id'] }}">
                No, cancel
            </a>
        </div>
    @endforeach

    <div id="drawer-create-product-default"
        class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
        tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
        <h5 id="drawer-label"
            class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">New
            Product</h5>
        <button type="button" data-drawer-dismiss="drawer-create-product-default"
            aria-controls="drawer-create-product-default"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        <form action="{{ route('admin.product.data-produk.new') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type product name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="category-create"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                    <select id="category-create" name="category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option hidden selected>Select category</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" {{ old('category') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="product_stock"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                    <input type="number" name="product_stock" id="product_stock"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="0." value="{{ old('stock') }}">
                    @error('stock')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex gap-4">
                    <div>
                        <label for="purchase_price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purchase price</label>
                        <input type="number" name="purchase_price" id="purchase_price"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Rp." value="{{ old('purchase_price') }}">
                        @error('purchase_price')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="selling_price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selling price</label>
                        <input type="number" name="selling_price" id="selling_price"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Rp." value="{{ old('selling_price') }}">
                        @error('sale_price')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea id="description" rows="4" name="desc"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Enter event description here" value="">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="bottom-0 left-0 flex justify-center w-full pb-4 space-x-4 md:px-4 md:absolute">
                    <button type="submit"
                        class="text-white w-full justify-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Add product
                    </button>
                    <button type="button" data-drawer-dismiss="drawer-create-product-default"
                        aria-controls="drawer-create-product-default"
                        class="inline-flex w-full justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        <svg aria-hidden="true" class="w-5 h-5 -ml-1 sm:mr-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </button>
                </div>
        </form>
    </div>
</div>
