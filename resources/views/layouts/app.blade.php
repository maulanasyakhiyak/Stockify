@extends('layouts.layout')

@section('body')
    <x-navbar-dashboard :user="Auth::user()"/>
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @php
            $role = Auth::user()->role ?? '';
        @endphp

        @switch($role)
            @case('admin')
                <x-sidebar.admin-sidebar />
            @break

            @case('manager')
                <x-sidebar.manajer-sidebar />
            @break

            @case('staff')
                <x-sidebar.staff-sidebar />
            @break

            @default
        @endswitch
        <div id="main-content" class="relative w-full bg-gray-50 lg:ml-64 dark:bg-gray-900">
            <main>
                @yield('content')
            </main>
            {{-- <x-footer-dashboard /> --}}
        </div>
    </div>
@endsection

