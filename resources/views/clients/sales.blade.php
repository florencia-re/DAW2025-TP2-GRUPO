@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Ventas de {{ $client->name }}</h1>

    @if (empty($sales))
        <p>No hay ventas disponibles.</p>
    @else
        <pre class="bg-white p-3 border rounded text-sm overflow-auto">
        {{ json_encode($sales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                </pre>
    @endif

    <a href="{{ route('clients.index') }}" class="underline mt-4 inline-block">Volver</a>
@endsection