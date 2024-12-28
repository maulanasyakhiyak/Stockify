@extends('layouts.layout')

@section('subtitle', 'Stok')
@section('body')
    <p>ini stok</p>
    <a href="{{ route('verification.send') }}">minta link</a>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">logout</button>
    </form>
@endsection
