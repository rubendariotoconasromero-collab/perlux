@extends('site.layout.layout')

@section('content')
    <div id="app">
        {{-- Pasamos el usuario autenticado con sus direcciones --}}
        <checkout-component 
            :user="{{ auth()->check() ? json_encode(auth()->user()->load('addresses')) : 'null' }}">
        </checkout-component>
    </div>
@endsection