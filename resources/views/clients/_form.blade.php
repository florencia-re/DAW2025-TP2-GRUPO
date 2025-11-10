@csrf

<div class="grid gap-4">

    <label>
        <span>Nombre</span>
        <input type="text" name="name" class="border p-2 w-full" value="{{ old('name', $client->name ?? '') }}"
            required>
    </label>
    <label>
        <span>Cuit</span>
        <input type="text" name="cuit" class="border p-2 w-full" value="{{ old('cuit', $client->cuit ?? '') }}"
               required>
    </label>

    <label>
        <span>Email</span>
        <input type="email" name="email" class="border p-2 w-full" value="{{ old('email', $client->email ?? '') }}"
            required>
    </label>

    <label>
        <span>Teléfono</span>
        <input type="text" name="phone" class="border p-2 w-full" value="{{ old('phone', $client->phone ?? '') }}">
    </label>

    <label>
        <span>Dirección</span>
        <input type="text" name="address" class="border p-2 w-full"
            value="{{ old('address', $client->address ?? '') }}">
    </label>

    <div class="flex gap-3">
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
        <a href="{{ route('clients.index') }}" class="underline">Cancelar</a>
    </div>

</div>
