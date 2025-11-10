@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Editar Cliente</h1>

    <form method="POST" action="{{ route('clients.update', $client) }}">
        @csrf
        @method('PUT')
        @include('clients._form')
    </form>
@endsection