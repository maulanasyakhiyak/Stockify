@props(['routeUpdate', 'user'])
<button type="button" id="drawer-update-button-product-{{ $user->id }}"
    data-drawer-target="drawer-update-product-{{ $user->id }}"
    data-drawer-show="drawer-update-product-{{ $user->id }}"
    aria-controls="drawer-update-product-{{ $user->id }}" data-drawer-placement="right"
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
<div id="drawer-update-product-{{ $user->id }}"
    class="fixed top-0 right-0 z-40 w-full text-left h-screen cursor-auto max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800"
    tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
    <h5 id="drawer-label"
        class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
        Update Product</h5>
    <button type="button" data-drawer-dismiss="drawer-update-product-{{ $user->id }}"
        aria-controls="drawer-update-product-{{ $user->id }}"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <form action="{{ route($routeUpdate,$user['id']) }}" method="POST" class="overflow-x-auto h-5/6">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label for="first_name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" name="first_name" id="first_name-{{ $user->id }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type product name" value="{{ $user['first_name'] }}">
            </div>
            <div>
                <label for="last_name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" name="last_name" id="last_name-{{ $user->id }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type product last_name" value="{{ $user['last_name'] }}">
            </div>
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="text" name="email" id="email-{{ $user->id }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type product email" value="{{ $user['email'] }}" {{$user->email_verified_at ? 'disabled' : ''}}>
            </div>
            <div>
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                <select id="role-{{$user->id}}" name="role" 
                    {{ $user->role == 'admin' ? 'disabled' : '' }}
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if ($user->role == 'admin')
                    <option selected>Admin</option>
                    @endif
                    <option value="manager" {{ 'manager' == $user->role ? 'selected' : '' }}>Manager</option>
                    <option value="staff" {{ 'staff' == $user->role ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

        </div>
        <div class="bottom-0 left-0 flex justify-center w-full pb-4 mt-4 space-x-4 sm:absolute sm:px-4 sm:mt-0">
            <button type="submit"
                class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Update
            </button>
        </div>
    </form>
</div>
