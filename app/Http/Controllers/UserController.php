<?php

// Declaramos el namespace del controlador, que indica su ubicación dentro del proyecto.
namespace App\Http\Controllers;

// Importamos el modelo User (representa la tabla "users" en la base de datos).
use App\Models\User;

// Importamos el helper Hash, usado para encriptar contraseñas de forma segura.
use Illuminate\Support\Facades\Hash;

// Importamos la clase personalizada que valida los formularios (Request).
use App\Http\Requests\UserRequest;

// Definimos la clase UserController, que maneja todas las operaciones del CRUD de usuarios.
class UserController extends Controller
{
    /**
     * Constructor del controlador.
     * Aplica el middleware 'auth', lo que obliga a que el usuario esté autenticado
     * para acceder a cualquiera de las rutas controladas por esta clase.
     */
    public function __construct()
    {
        $this->middleware('auth'); // protege todas las rutas del CRUD
    }

    /**
     * Método index()
     * Ruta: GET /users
     * Muestra la lista de usuarios paginada.
     */
    public function index()
    {
        // Obtiene todos los usuarios de la base de datos, ordenados por ID de manera ascendente.
        // paginate(10) muestra solo 10 resultados por página.
        $users = User::orderBy('id', 'asc')->paginate(10);

        // Envía los datos obtenidos a la vista "users/index.blade.php"
        // usando la función compact() para pasar la variable $users.
        return view('users.index', compact('users'));
    }

    /**
     * Método create()
     * Ruta: GET /users/create
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        // Carga la vista que contiene el formulario de alta de usuario.
        return view('users.create');
    }

    /**
     * Método store()
     * Ruta: POST /users
     * Guarda un nuevo usuario en la base de datos.
     * Recibe un objeto UserRequest (que valida los datos antes de llegar aquí).
     */
    public function store(UserRequest $request)
    {
        // Los datos ya fueron validados automáticamente por UserRequest.
        // validated() devuelve un array limpio con los datos correctos.
        $validated = $request->validated();

        // Crea un nuevo registro en la tabla "users" usando los datos validados.
        // Se usa Hash::make() para encriptar la contraseña antes de guardarla.
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Redirige al listado de usuarios y muestra un mensaje de éxito en pantalla.
        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Método edit()
     * Ruta: GET /users/{id}/edit
     * Muestra el formulario de edición de un usuario existente.
     */
    public function edit($id)
    {
        // Busca el usuario por su ID. Si no existe, lanza un error 404 automáticamente.
        $user = User::findOrFail($id);

        // Envía el usuario encontrado a la vista "users/edit.blade.php"
        return view('users.edit', compact('user'));
    }

    /**
     * Método update()
     * Ruta: PUT /users/{id}
     * Actualiza los datos de un usuario en la base de datos.
     */
    public function update(UserRequest $request, $id)
    {
        // Busca el usuario que se va a editar por su ID.
        $user = User::findOrFail($id);

        // Valida los datos nuevamente con UserRequest.
        $validated = $request->validated();

        // Actualiza los campos 'name' y 'email' con los datos validados.
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Si el usuario ingresó una nueva contraseña, se encripta y se actualiza.
        // Si está vacío, se deja la anterior.
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Guarda los cambios en la base de datos.
        $user->save();

        // Redirige al listado con un mensaje de éxito.
        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Método destroy()
     * Ruta: DELETE /users/{id}
     * Elimina un usuario de la base de datos.
     */
    public function destroy($id)
    {
        // Busca el usuario por ID y lo elimina.
        // Este método realiza un borrado físico (no lógico).
        User::findOrFail($id)->delete();

        // Redirige de nuevo al listado mostrando mensaje de eliminación.
        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}

/*
Este archivo UserController.php = es el controlador del CRUD de usuarios.
**** Su función es recibir las peticiones del navegador 
(crear, editar, borrar, etc.), validar los datos con el UserRequest y 
comunicarse con el modelo User (la base de datos).*/