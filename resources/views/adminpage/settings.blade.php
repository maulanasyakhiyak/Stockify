@extends('layouts.app')

@section('subtitle', 'Settings')

@section('js')
    @vite(['resources/js/admin/settings.js'])
@endsection
@section('content')
    <div class="grid grid-cols-1 gap-4 p-4">
        <div class="flex flex-col">
            <div class="mb-4 flex justify-between">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Settings</h1>
            </div>
            <div class="relative">
                <div class="mb-3">
                    <div class="grid grid-cols-[25rem_auto] w-full border-b border-gray-300 dark:border-gray-100 py-4">
                        <div class="text-sm sm:text-base font-semibold text-gray-800 dark:text-white mb-2 flex items-center">
                            App Name</div>
                        <div class="w-full">
                            <input type="text" id="NEW_APP_NAME"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search by product name" name="NEW_APP_NAME"
                                value="{{ $settings->app_name }}">
                        </div>
                    </div>
                    <div class="grid grid-cols-[25rem_auto] w-full border-b border-gray-300 dark:border-gray-100 py-4">
                        <div
                            class="text-sm sm:text-base font-semibold text-gray-800 dark:text-white mb-2 flex flex-col justify-center">
                            <h1>Logo</h1>
                            <p class="text-gray-500 dark:text-gray-300 font-normal">This will displayed on title</p>
                        </div>
                        <div class="w-full">
                            <div
                                class="w-[100px] h-[100px] rounded-full border dark:border-gray-300 overflow-hidden relative">
                                <label for="logo"
                                    class="w-full h-full absolute z-10 bg-gray-500 opacity-0 hover:opacity-50 text-white flex justify-center items-center hover:cursor-pointer">
                                    <i class="fa-solid fa-pen text-lg"></i>
                                </label>
                                @php
                                    $image_path = $settings->logo_path
                                @endphp
                                <input type="file" id="logo" accept="image/*" data-image-path="{{$image_path}}" data-preview-target="logo-image"
                                    hidden>
                                <img src="{{ asset($image_path) }}" data-preview="logo-image"
                                    class="w-full p-2" alt="">
                            </div>
                        </div>
                    </div>
 
                </div>
                <div class="">
                    <form action="{{ route('admin.settings.store') }}" method="POST" id="FORM_SETTING_APP" enctype="multipart/form-data">
                        @csrf
                        <button id="button-submit" type="submit"
                            class="flex items-center gap-2 justify-center w-full px-4 py-2 text-sm font-medium
                            text-gray-50 bg-blue-500 border border-gray-100 rounded-lg md:w-auto focus:outline-none
                            hover:bg-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-200
                            dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600
                            dark:hover:text-white dark:hover:bg-gray-700 disabled:bg-blue-300 disabled:hover:bg-blue-300"
                            disabled>
                            Save changes
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
