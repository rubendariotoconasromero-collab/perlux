@extends('admin.layout.index')
{{-- @php
    $id_usuario=Auth::user()->id??'';
@endphp --}}
@section('contenido')


    <div class="container">
        <div class="page-inner">
            <div id="app">
                <product-component></product-component>
            </div>
        </div>
    </div>


@endsection




   

