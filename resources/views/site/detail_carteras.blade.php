@extends('site.layout.layout')

@section('content')
    <div id="app">
        <detail-carteras-component :product-id="{{ json_encode(request()->product_id) }}" :user="{{ auth()->check() ? json_encode(auth()->user()->load('addresses')) : 'null' }}"></detail-carteras-component>
    </div>
@endsection
