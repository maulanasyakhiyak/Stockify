@props(['id' => null, 'target' => null, 'item' => null , 'routeUpdate',' product', 'categories'])
<button type="button" id="drawer-update-button-product-{{ $id }}"
    data-drawer-target="drawer-update-product-{{ $target }}"
    data-drawer-show="drawer-update-product-{{ $target }}"
    aria-controls="drawer-update-product-{{ $target }}" data-drawer-placement="right"
    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
        </path>
        <path fill-rule="evenodd"
            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
            clip-rule="evenodd"></path>
    </svg>
</button>
<!-- Edit Product Drawer -->
<div id="drawer-update-product-{{ $target }}"
    class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
    tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
    <h5 id="drawer-label"
        class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
        Update Product</h5>
    <button type="button" data-drawer-dismiss="drawer-update-product-{{ $target }}"
        aria-controls="drawer-update-product-{{ $target }}"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <form action="{{ route($routeUpdate,$product['id']) }}" method="POST" class="overflow-x-auto h-5/6" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" name="name" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type product name" value="{{ $product['name'] }}">
                    @error('name')
                        <span class="text-red-500 pe-3">{{ $message }}</span>
                    @enderror
            </div>
            <div>
                <div class="flex justify-between w-full">
                    <label for="atribute"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Atribute <span class="text-gray-500 text-xs">(optional)</span></label>
                    <button type="button" data-add-atribute-target="addFormData-{{$product['id']}}" class="cursor-pointer mb-2">
                        <i
                            class="fa-solid fa-plus text-white bg-blue-500 hover:bg-blue-600 p-[0.2rem] text-xs rounded-full"></i>
                    </button>
                </div>

                <div id="addFormData-{{$product['id']}}">
                    @if ($product->attributes)
                        @forelse ($product->attributes as $index => $atribute)
                            <div data-atribute-form={{ $index }} data-atribute-index="{{$index}}"
                                class="mt-2 relative w-full flex overflow-hidden bg-white border divide-x-2 divide-solid dark:divide-gray-500 border-gray-300 text-gray-900 text-sm rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <div class="atribute">
                                    <input type="text" name="atributes[{{ $index }}][name]"
                                        class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                                        placeholder="Nama"
                                        value="{{ old('atributes.' . $index . '.atribute', $atribute->name) }}">
                                </div>
                                <div class="value">
                                    <input type="text" name="atributes[{{ $index }}][value]"
                                        class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                                        placeholder="Value"
                                       value="{{ old('atributes.' . $index . '.value', $atribute->value) }}">
                                </div>
                                <button type="button" @if ($index == 0) disabled @endif
                                    data-remove-atribute-form={{ $index}} data-atribute-parent="addFormData-{{$product['id']}}"
                                    class="flex items-center justify-center flex-grow text-gray-900 dark:text-white disabled:text-gray-300 dark:disabled:text-gray-500 dark:hover:text-red-500 hover:text-red-500">
                                    <i class="fa-solid fa-minus "></i>
                                </button>
                            </div>
                            @empty
                            <div data-atribute-form="0" data-atribute-index="0" class="relative w-full flex overflow-hidden bg-white border divide-x-2 divide-solid dark:divide-gray-500 border-gray-300 text-gray-900 text-sm rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <div class="atribute">
                                    <input type="text" name="atributes[0][name]"
                                        class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                                        placeholder="Nama">
                                </div>
                                <div class="value">
                                    <input type="text" name="atributes[0][value]"
                                        class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                                        placeholder="Val (optional)">
                                </div>
                                <button disabled type="button"
                                    class="flex items-center justify-center flex-grow text-gray-900 dark:text-white disabled:text-gray-300 dark:disabled:text-gray-500 dark:hover:text-red-500 hover:text-red-500">
                                    <i class="fa-solid fa-minus "></i>
                                </button>
                            </div>
                        @endforelse
                        @else
                        <div data-atribute-form="0" data-atribute-index="0" class="relative w-full flex overflow-hidden bg-white border divide-x-2 divide-solid dark:divide-gray-500 border-gray-300 text-gray-900 text-sm rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <div class="atribute">
                                <input type="text" name="atributes[0][name]"
                                    class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                                    placeholder="Nama">
                            </div>
                            <div class="value">
                                <input type="text" name="atributes[0][value]"
                                    class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white"
                                    placeholder="Val (optional)">
                            </div>
                            <button disabled type="button"
                                class="flex items-center justify-center flex-grow text-gray-900 dark:text-white disabled:text-gray-300 dark:disabled:text-gray-500 dark:hover:text-red-500 hover:text-red-500">
                                <i class="fa-solid fa-minus "></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div>
                <label for="category-update"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                <select id="category-update" name="category-update"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option selected hidden>Select</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $product->category_id ? 'selected' : '' }}>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sku"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                <input type="text" name="sku" id="sku"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="0." value="{{ $product['sku'] }}">
            </div>
            <div class="flex gap-4">
                <div>
                    <label for="purchase_price"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purchase
                        price</label>
                    <input type="text" name="purchase_price" id="purchase_price"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Rp." value="{{ $product['purchase_price'] }}">
                </div>

                <div>
                    <label for="selling_price"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selling
                        price</label>
                    <input type="number" name="selling_price" id="selling_price"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Rp." value="{{ $product['selling_price'] }}">
                </div>
            </div>

            <div>
                <label for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <textarea id="description" rows="4" name="description"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Enter event description here" >{{ $product['description'] }}</textarea>
            </div>

            <div class="flex items-center justify-center w-full" >
                <label for="product_update_image_{{$product['id']}}" data-dropfile="product_update_image_{{$product['id']}}"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    @if ($product['image'])
                    <img class="w-full h-full rounded-lg" src="{{ asset('images/original/'.$product['image']) }}" alt=""
                        data-image="product_update_image_{{$product['id']}}">
                        @else
                        <img class="w-full h-full rounded-lg" src="{{ asset('images/original/default.png') }}" alt=""
                            data-image="product_update_image_{{$product['id']}}" hidden>

                    @endif
                    <div class="{{$product['image'] ? 'hidden' : 'flex'}} flex-col items-center justify-center pt-5 pb-6" data-noImage="product_update_image_{{$product['id']}}">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)
                        </p>
                    </div>
                    <input type="file" id="product_update_image_{{$product['id']}}" name="product_update_image_{{$product['id']}}" data-file="product_update_image_{{$product['id']}}"  accept="image/*" hidden />
                </label>
            </div>

        </div>
        <div class="bottom-0 left-0 flex justify-center w-full pb-4 mt-4 space-x-4 sm:absolute sm:px-4 sm:mt-0">
            <button type="submit"
                class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Update
            </button>
            <button type="button"
                class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20"
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
