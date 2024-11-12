@props(['id', 'categories', 'routeUpdate', 'routeDelete'])

<div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">id</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Name
                        </th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Description</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{ $category['id'] }}</td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="text-base font-semibold">{{ $category['name'] }}</div>
                            </td>
                            <td class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400"> {{ $category['description'] }}</td>
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <x-tables.admin.category.button-update :id="$category['id']" :target="$category['id']"
                                    :item="$category['name']" :routeUpdate="$routeUpdate" :category="$category" />
                                <x-tables.admin.category.button-delete :id="$category['id']" :target="$category['id']"
                                    :item="$category['name']" :routeDelete="$routeDelete" />
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
    {{ $categories->links() }}
</div>
