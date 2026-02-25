@php
    use Illuminate\Http\Request;
    
@endphp
@extends('site.layout.layout')

@section('content')

    <div id="app">
        @guest
            <login-component></login-component>
        @else
            <personaldata-component :user="{{ json_encode(auth()->user()->load('addresses')) }}" :initial-section="'{{ $section ?? 'perfil' }}'">></personaldata-component>
        @endguest
    </div>

@endsection


   
