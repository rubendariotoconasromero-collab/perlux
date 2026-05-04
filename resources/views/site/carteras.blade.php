@extends('site.layout.layout')

@section('content')
    <div id="app">
        <carteras-component :collection="{{json_encode($CollectionID??'')}}" :user="{{ auth()->check() ? json_encode(auth()->user()->load('addresses')) : 'null' }}"></carteras-component>
    </div>
@endsection
