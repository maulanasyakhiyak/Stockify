@extends('layouts.app')

@section('body')
    <x-navbar-dashboard />
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @php
            $role = 'admin';
        @endphp

        @switch($role)
            @case('admin')
                <x-sidebar.admin-sidebar />
            @break

            @case('manajer')
                <x-sidebar.manajer-sidebar />
            @break

            @case('staff')
                <x-sidebar.staff-sidebar />
            @break

            @default
        @endswitch
        <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
            <main>
                @yield('content')
            </main>
            {{-- <x-footer-dashboard /> --}}
        </div>
    </div>
@endsection

