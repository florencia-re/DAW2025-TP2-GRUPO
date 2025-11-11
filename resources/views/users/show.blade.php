{{-- Detalle simple --}}
@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-8 text-gray-200">
    <h1 class="text-2xl font-bold mb-4">Detalle de usuario</h1>

    <p><strong>ID:</strong> {{ $user->id }}</p>
    <p><strong>Nombre:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Creado:</strong> {{ $user->created_at }}</p>

    <div class="mt-4">
        <a href="{{ route('users.index') }}" class="text-blue-400 hover:underline">Volver al listado</a>
    </div>
</div>
@endsection
