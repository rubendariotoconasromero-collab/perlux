@php
    use Illuminate\Http\Request;

    // $id_usuario=Auth::user()->id??'';
    // $path = request()->path(); 
@endphp
@extends('site.layout.layout')

@section('content')

    <div id="app">
        <home-component :user="{{ auth()->check() ? json_encode(auth()->user()->load('addresses')) : 'null' }}"></home-component>
    </div>

@endsection


   
