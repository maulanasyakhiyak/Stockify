@extends('layouts.app')

@section('subtitle', 'Dashboard')

@section('js')
 @vite(['resources/js/staff/stock.js']);
@endsection

@section('content')
    <div class="grid grid-cols-1 gap-4 p-4">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Assignment</h1>
        
        <div class="relative bg-white shadow dark:bg-gray-800 sm:rounded-lg p-4">
            <div class="w-full flex flex-col">
                    @php
                        $a = $stockTransaction->whereIn('status', ['completed', 'cancelled'])->count(); //data yang telah dikerjakan
                        $b = $stockTransaction->count(); // keseluran data
                        $persentase = number_format($b > 0 ? ($a / $b) * 100 : 0, 2);
                        if ($persentase < 30) {
                            $bgColor = 'bg-red-500'; // Merah
                        } elseif ($persentase < 75) {
                            $bgColor = 'bg-yellow-300'; // Kuning
                        } else {
                            $bgColor = 'bg-blue-600'; // Biru
                        }
                    @endphp
                <div class="mb-4">
                    <h1 class="text-gray-800 dark:text-gray-400 mb-2"> {{$a}}/{{$b}} data telah dikerjakan</h1>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="{{$bgColor}} h-2.5 rounded-full" style="width:{{$persentase}}%"></div>
                    </div>
                </div>
                <x-tables.staff.table-confirmation-transaction :stockTransaction="$stockTransaction" />
                </div>
        </div>

    </div>
@endsection
