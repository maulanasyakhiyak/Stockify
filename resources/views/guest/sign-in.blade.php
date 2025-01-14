@extends('layouts.layout')

@section('subtitle','Login')

@section('js')
@vite(['resources/js/guest/login.js'])
@endsection

@section('body')
    <body>
        <div class="flex flex-col items-center justify-center px-6 mx-auto h-screen pt:mt-0 dark:bg-gray-900">
            <a href="{{ url('/')}}" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
                <img src="{{ asset($settings->logo_path) }}" class="mr-4 h-11" alt="FlowBite Logo">
                <span>{{$settings->app_name}}</span>
            </a>
            <!-- Card -->
            <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Sign in to platform
                </h2>
                <form class="mt-8 space-y-6" action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{old('email')}}" placeholder="name@company.com" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
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
                    <div class="w-full flex flex-col justify-center">
                        <button type="submit" class="mb-4 w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Login to your account</button>
                        <div class="flex items-start">
                            <a href="{{ route('password.request') }}" class="text-sm text-primary-700 hover:underline dark:text-primary-500">Lost Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
@endsection
