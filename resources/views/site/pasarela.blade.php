@php
    use Illuminate\Http\Request;

        $user = auth()->user() ? auth()->user()->load('addresses') : null;
    
        $safeUser = [
            'id' => $user->id ?? null,
            'name' => $user->name ?? 'Usuario',
            'email' => $user->email ?? '',
            'email_verified_at' => $user->email_verified_at ?? null,
            'photo_url' => $user->photo_url ?? '/images/default-avatar.png',
            'tipo' => $user->tipo ?? 'local',
            'estado' => $user->estado ?? 'activo',
            'role_id' => $user->role_id ?? 1,
            'created_at' => $user->created_at ?? now(),
            'updated_at' => $user->updated_at ?? now(),
            'phone' => $user->phone ?? '',
            'last_name' => $user->last_name ?? '',
            'document_type' => $user->document_type ?? '',
            'dni' => $user->dni ?? '',
            'addresses' => $user->addresses ?? []
        ];
@endphp
@extends('site.layout.layout')

@section('content')
    <div id="app">
        <pasarela-component :user="{{ json_encode($safeUser) }}"></pasarela-component>
    </div>
@endsection


   
