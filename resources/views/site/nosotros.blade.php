@php
    use Illuminate\Http\Request;

    // $id_usuario=Auth::user()->id??'';
    // $path = request()->path(); 
@endphp
@extends('site.layout.layout')

@section('content')

    <div id="app">
        <nosotros-component :user="{{ auth()->check() ? json_encode(auth()->user()->load('addresses')) : 'null' }}"></nosotros-component>
    </div>

@endsection


   
