@extends('site.layout.layout')

@section('content')

    <div id="app">
        <claimsbook-component :user="{{ auth()->check() ? json_encode(auth()->user()->load('addresses')) : 'null' }}"></claimsbook-component>
    </div>

@endsection


   
