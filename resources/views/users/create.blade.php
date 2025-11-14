@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Nuevo Usuario</h1>

    <form method="POST" action="{{ route('users.store') }}">
        @include('users._form')
    </form>
@endsection