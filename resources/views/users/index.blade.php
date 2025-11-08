@extends('layouts.app')
@section('content')
  <h1 class="text-xl font-semibold mb-4">Usuarios</h1>

  <table class="min-w-full bg-white border">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-2">ID</th>
        <th class="p-2">Nombre</th>
        <th class="p-2">Email</th>
        <th class="p-2">Rol</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($users as $u)
        <tr class="border-t">
          <td class="p-2">{{ $u->id }}</td>
          <td class="p-2">{{ $u->name }}</td>
          <td class="p-2">{{ $u->email }}</td>
          <td class="p-2">{{ $u->role }}</td>
        </tr>
      @empty
        <tr><td class="p-3" colspan="4">No hay usuarios.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">{{ $users->links() }}</div>
@endsection
