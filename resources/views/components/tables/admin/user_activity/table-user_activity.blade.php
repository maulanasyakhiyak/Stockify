@props(['user_activity'])

<div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
            <table class="w-full divide-y divide-gray-200 table-auto dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr class="">
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Nama</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Role</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Tindakan </th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Deskripsi</th>
                        <th scope="col"
                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Waktu</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                    @forelse ($user_activity as $item)
                        @php
                            $username = $item->user->first_name . ' ' . $item->user->last_name;
                            $date = \Carbon\Carbon::parse($item->created)->format('d M Y h:i A');

                        @endphp
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <td class="p-4 text-base text-gray-600 whitespace-nowrap dark:text-white">
                                {{ $username }}</td>
                            <td
                                class="p-4 text-base text-gray-600 whitespace-nowrap dark:text-white">
                                {{ $item->user->role }}</td>
                            <td
                                class="p-4 text-base text-gray-600 whitespace-nowrap dark:text-white">
                                {{ $item->activity }}</td>
                            <td class="p-4 text-base text-gray-600 whitespace-nowrap dark:text-white truncate xl:max-w-xs">
                                {{ $item->description }}</td>
                            <td class="p-4 text-base text-gray-600 whitespace-nowrap dark:text-white">
                                {{ $date }}</td>
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
