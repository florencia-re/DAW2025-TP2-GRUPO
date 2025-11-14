@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Editar Usuario</h1>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')
        @include('users._form')
    </form>
@endsection