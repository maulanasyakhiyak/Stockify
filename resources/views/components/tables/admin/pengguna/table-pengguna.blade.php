@props(['users'])

<div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
            <table class="w-full divide-y divide-gray-200 table-auto dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Nama</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Alamat </th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            phone</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            email</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            role</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($users as $item)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white overflow-hidden">
                                {{ $item->name }}</td>
                            <td class="p-4 text-base font-medium text-gray-500 whitespace-nowrap dark:text-white truncate xl:max-w-xs">
                                {{ $item->address }}
                                
                            </td>
                            <td
                                class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->phone }}</td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->email }}</td>
                            <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->role }}</td>
                            <td class="p-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <x-tables.admin.pengguna.button-update routeUpdate='admin.suplier.update' :supplier="$item" />
                                <x-tables.admin.pengguna.button-delete routeDelete='admin.suplier.update' :id="$item->id" :supplier="$item" />
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
