@extends('site.layout.layout')

@section('content')

    <div id="app">
        <business-info-component :user="{{ auth()->check() ? json_encode(auth()->user()->load('addresses')) : 'null' }}"></business-info-component>
    </div>

@endsection


   
