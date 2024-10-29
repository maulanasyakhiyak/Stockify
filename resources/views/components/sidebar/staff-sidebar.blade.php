@php
    // ICON
    $dashboard = '

    ';
@endphp

<x-sidebar-dashboard>
    <ul class="pb-2 space-y-2">
        <x-sidebar-menu-dashboard routeName="admin.dashboard" title="Dashboard"
            icon='<svg class="sidebar-icon-style" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>' />
        <x-sidebar-menu-dashboard routeName="admin.stok" title="Stok"
            icon='<svg class="sidebar-icon-style" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M234.5 5.7c13.9-5 29.1-5 43.1 0l192 68.6C495 83.4 512 107.5 512 134.6l0 242.9c0 27-17 51.2-42.5 60.3l-192 68.6c-13.9 5-29.1 5-43.1 0l-192-68.6C17 428.6 0 404.5 0 377.4L0 134.6c0-27 17-51.2 42.5-60.3l192-68.6zM256 66L82.3 128 256 190l173.7-62L256 66zm32 368.6l160-57.1 0-188L288 246.6l0 188z"/></svg>' />
    </ul>

</x-sidebar-dashboard>


{{-- <x-sidebar-menu-dropdown-dashboard routeName="practice.*" title="Judul Dropdown">
    <x-sidebar-menu-dropdown-item-dashboard routeName="a" title="Judul Item1" />
    <x-sidebar-menu-dropdown-item-dashboard routeName="a" title="Judul Item2" />
</x-sidebar-menu-dropdown-dashboard> --}}
