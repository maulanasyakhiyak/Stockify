@extends('layouts.admin')

@section('subtitle', 'Produk')

@section('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('js/data-product.js') }}"></script>
    @if (session('openDrawer'))
        <script>
            console.log('TES');

        </script>
    @endif

@endsection

@section('content')
    @php
        // $json = Illuminate\Support\Facades\File::get(public_path('data/products.json'));
        // $data = json_decode($json, true);
    @endphp

    @livewire('data-product')

    {{-- TOOLTIP --}}
    <div id="delete-button" role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-700 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-900">
        Delete
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
    <div id="export-button" role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-700 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-900">
        Export
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>


@endsection
