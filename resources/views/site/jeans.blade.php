@php
    use Illuminate\Http\Request;

    // $id_usuario=Auth::user()->id??'';
    // $path = request()->path(); 
@endphp
@extends('site.layout.layout')

@section('content')

    <div id="app">
        <jeans-component :collection="{{json_encode($CollectionID??'')}}" :user="{{ auth()->check() ? json_encode(auth()->user()->load('addresses')) : 'null' }}"></novias-component>
    </div>

@endsection


   
