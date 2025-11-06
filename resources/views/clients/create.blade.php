@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Nuevo Cliente</h1>

    <form method="POST" action="{{ route('clients.store') }}">
        @include('clients._form')
    </form>
@endsection