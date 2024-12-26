@extends('layouts.app')

@section('subtitle', 'Tambah Pengguna')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
@endsection

@section('js')
    @vite(['resources/js/admin/pengguna.js'])
@endsection

@section('content')
    <div class="grid grid-cols-1 gap-4 p-4">
        <div class="flex flex-col">
            <div class="mb-4 flex justify-between">

            </div>
            <div class="">
                <form class="w-full p-4" action="{{ route('admin.pengguna.new.process') }}" method="POST">
                    @method('put')
                    @csrf
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mb-4">Tambah User</h1>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="new_first_name" id="new_first_name"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent  border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{old('new_first_name')}}" />
                            <label for="new_first_name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                                name</label>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="new_last_name" id="new_last_name"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{old('new_last_name')}}" />
                            <label for="new_last_name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                                name</label>
                        </div>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email" name="new_email" id="new_email"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " value="{{old('new_email')}}" />
                        <label for="new_email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                            address</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <div
                            class="border-b-2 border-gray-300 dark:border-gray-600 focus-within:border-blue-600 transition-colors">
                            <input type="password" name="new_password" id="new_password"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent focus:ring-0 border-none focus:outline-none dark:text-white peer"
                                placeholder=" " value="{{old('new_password')}}" />
                            <label for="new_password"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                            <button type="button" id="togglePassword" data-toggle-eye="new_password"
                                class="absolute right-0 top-2 text-gray-500 dark:text-gray-400">
                                <i data-toggle-eye-icon="new_password" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <div
                            class="border-b-2 border-gray-300 dark:border-gray-600 focus-within:border-blue-600 transition-colors">
                            <input type="password" name="confirm_new_password" id="confirm_new_password"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent focus:ring-0 border-none focus:outline-none dark:text-white peer"
                                placeholder=" " value="{{old('confirm_new_password')}}" />
                            <label for="confirm_new_password"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm Password</label>
                            <button type="button" data-toggle="togglePassword" data-toggle-eye="confirm_new_password"
                                class="absolute right-0 top-2 text-gray-500 dark:text-gray-400">
                                <i data-toggle-eye-icon="confirm_new_password" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <div class="relative z-0 w-full mb-5 group">

                            <label for="underline_select" class="sr-only">Underline select</label>
                            <select name="new_role"
                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-400 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                                <option selected hidden>Pilih role</option>
                                <option value="admin">Admin</option>
                                <option value="manager">manager</option>
                                <option value="staff">staff</option>
                            </select>

                        </div>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>

            </div>
        </div>
    </div>
@endsection
