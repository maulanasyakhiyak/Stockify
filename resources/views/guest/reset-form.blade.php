@extends('layouts.layout')

@section('subtitle','Login')

@section('js')
@vite(['resources/js/guest/login.js'])
@endsection

@section('body')
    <body>
        <div class="flex flex-col items-center justify-center px-6 mx-auto h-screen pt:mt-0 dark:bg-gray-900">
            <div class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
                <img src="{{ asset($settings->logo_path) }}" class="mr-4 h-11" alt="FlowBite Logo">
                <span>{{$settings->app_name}}</span>
            </div>
            <!-- Card -->
            <div class="w-full max-w-xl p-6 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="w-full text-center">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Create new password
                    </h2>
                </div>
                <form class="mt-4 space-y-3" action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <div class="relative bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <input type="password" name="password" id="password"
                                   class="block w-full text-sm text-gray-900 bg-transparent focus:ring-0 border-none focus:outline-none dark:text-white peer"
                                   placeholder="••••••••" />
                            <button type="button" data-toggle="togglePassword" data-toggle-eye="password"
                                    class="absolute right-3 top-2 text-gray-500 dark:text-gray-400">
                                    <i data-toggle-eye-icon="password" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                        <div class="relative bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <input type="password" name="confirm_password" id="confirm_password"
                                   class="block w-full text-sm text-gray-900 bg-transparent focus:ring-0 border-none focus:outline-none dark:text-white peer"
                                   placeholder="••••••••" />
                            <button type="button" data-toggle="togglePassword" data-toggle-eye="confirm_password"
                                    class="absolute right-3 top-2 text-gray-500 dark:text-gray-400">
                                    <i data-toggle-eye-icon="confirm_password" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="w-full flex flex-col justify-center">
                        <button type="submit" class="mb-4 w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Reset password</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
@endsection
