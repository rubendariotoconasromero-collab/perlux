@extends('admin.layout.index')
@php
    $id_usuario=Auth::user()->id??'';
@endphp
@section('contenido')

    <div class="container">
        <div class="page-inner">
            <div id="app">
                <bienvenida-component :user-id="{{json_encode($id_usuario)}}"></bienvenida-component>
            </div>
        </div>
    </div>

@endsection




   

