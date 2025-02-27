@props(['icon' => null, 'routeName' => null, 'title' => null])
<li>
    <a href="{{ route($routeName) }}"
        class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-6 dark:text-gray-200 dark:hover:bg-gray-700
    {{ request()->routeIs($routeName) || request()->routeIs($routeName . '.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
    <i class='{{request()->routeIs($routeName) || request()->routeIs($routeName . '.*') ? 'fa-solid' : 'fa-regular' }} {{$icon}} pe-2'></i>
        {{ $title }}
    </a>
</li>
