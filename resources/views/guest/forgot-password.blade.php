@extends('layouts.layout')

@section('subtitle','Login')

@section('js')
{{-- @vite(['resources/js/guest/login.js']) --}}
@endsection

@section('body')
    <body>
        <div class="flex flex-col items-center justify-center px-6 mx-auto h-screen pt:mt-0 dark:bg-gray-900">
            <a href="{{ url('/')}}" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
                <img src="{{ asset($settings->logo_path) }}" class="mr-4 h-11" alt="FlowBite Logo">
                <span>{{$settings->app_name}}</span>
            </a>
            <!-- Card -->
            <div class="w-full max-w-xl p-6 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="w-full text-center">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Reset your password
                    </h2>
                    <span class="text-gray-500 dark:text-white">Please enter your email below and we'll send you reset password link</span>
                </div>
                <form class="mt-4" action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mt-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter your email">
                    </div>
                    <div class="w-full flex flex-col justify-center mt-4">
                        <button type="submit" class="mb-4 w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Send link</button>
                        <div class="flex items-center text-primary-700 dark:text-primary-500">
                            <i class="fa-solid fa-arrow-left pe-2"></i> 
                            <a href="{{ route('login') }}" class="text-sm">Back to login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
@endsection
