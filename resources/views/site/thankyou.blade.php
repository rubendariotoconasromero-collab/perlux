@extends('site.layout.layout')

@section('content')
    <div id="app">
        <thank-you-component order-reference="{{ $orderReference }}"></thank-you-component>
    </div>
@endsection