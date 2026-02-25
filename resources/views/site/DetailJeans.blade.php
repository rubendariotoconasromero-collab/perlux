@php
    use Illuminate\Http\Request;

@endphp
@extends('site.layout.layout')

@section('content')

    <div id="app">
        <detailjeans-component :product-id="{{json_encode($product_id)}}" :user="{{ auth()->check() ? json_encode(auth()->user()->load('addresses')) : 'null' }}"></detailjeans-component>
    </div>

@endsection


   
