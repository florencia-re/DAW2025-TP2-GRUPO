@csrf

<div class="grid gap-4">

    <label>
        <span>Nombre</span>
        <input type="text" name="name" class="border p-2 w-full" value="{{ old('name', $user->name ?? '') }}"
            required>
    </label>

    <label>
        <span>Email</span>
        <input type="email" name="email" class="border p-2 w-full" value="{{ old('email', $user->email ?? '') }}"
            required>
    </label>

    <label>
        <span>Contraseña {{ isset($user) ? '(dejar vacío para mantener la actual)' : '' }}</span>
        <input type="password" name="password" class="border p-2 w-full" {{ !isset($user) ? 'required' : '' }}>
    </label>

    <label>
        <span>Rol</span>
        <input type="text" name="role" class="border p-2 w-full" value="{{ old('role', $user->role ?? '') }}">
    </label>

    <div class="flex gap-3">
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
        <a href="{{ route('users.index') }}" class="underline">Cancelar</a>
    </div>

</div>
