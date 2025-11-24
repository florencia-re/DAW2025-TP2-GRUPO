# Documentación Trabajo Práctico 2 - DAW 2025

## 1. Visión General
Sistema de gestión de ventas y clientes creado con Laravel que se integra con una API externa para la recuperación de datos de los datos de las ventas a los distintos usuarios. La aplicación implementa una arquitectura en capas con una clara separación entre los controladores HTTP, la lógica del servicio y el acceso a los datos.

### 1.1 Propósito del sistema
La aplicación sirve como interfaz de gestión para tres entidades principales:

1. Clientes: Operaciones CRUD con soft-delete
2. Usuario: Carga de usuario
3. Ventas: Lectura de datos obtenidos de una API externa

El sistema requiere autenticación de doble capa: los usuarios deben autenticarse contra el sistema de autenticación interno de Laravel y autenticarse por separado con la API externa para acceder a los datos de ventas.

### 1.2 Stack tecnológico
| Capa     | Tecnología                |
|----------|---------------------------|
| Backend | Laravel 11.x with PHP 8.2+ |
| Frontend| Vite 5.x with Hot Moduel Replacement |
| CSS Framework | Tailwind v3.x with v4 compatibility layer |
| JavaScript | Alpine.js for reactive components, Axios for HTTP |
| Data base | PostgreSQL/MySQL via Eloquent ORM |
| HTTP Client | GuzzleHttp with CookieJar for external API |
| Session Management | Laravel session with cookie storage |
| Authentication | Laravel Breeze (internal) + external API auth |

### 1.3 Arquitectura
    
    - Capa HTTP: validación de solicitudes, comprobaciones de autenticación, representación de respuestas
    - Capa de servicio: lógica de negocio, filtrado de datos, autorización
    - Capa de repositorio: abstracción de acceso a datos con contratos de interfaz
    - Capa de datos: almacenamiento persistente (base de datos) y fuentes de datos externas (API)

La inyección de dependencias está configurada en app/Providers/AppServiceProvider.php donde las interfaces del repositorio están vinculadas a implementaciones concretas

## 2. Componentes principales

### 2.1 Capa controlador

| Controlador | Responsabilidad principal | Métodos clave |
|-------------|---------------------------|---------------|
| SalesController | Visualización de datos de ventas | listSalesByCuit() en app/Http/Controllers/SalesController.php |
| AuthenticatedSessionController | Autenticación dual | store() en app/Http/Controllers/Auth/AuthenticatedSessionController.php|
| | |  authenticateWithExternalApi() app/Http/Controllers/Auth/AuthExternalSessionController.php |
| ClientController | CRUD de cliente + eliminaciones temporales | Métodos de recursos + archived(), restore(), sales() | 
| UserController | CRUD de usuario con sincronización externa | Métodos de recursos con carga de API externa |

### 2.2 Capa de servicio

| Servicio | Propósito | Dependencias |
|----------|---------------------------|----------|
| VentasService | Recuperación y filtrado de ventas | SalesRepositoryInterface, ClientService, UserService |
| ClientService | Lógica de negocio del cliente | ClientRepositoryInterface |
| UserService | Gestión de usuarios + carga externa | UserRepositoryInterface, cliente HTTP |

Este VentasService es el componente más complejo, implementa app/Services/VentasService.php con amplio registro para depurar operaciones de transformación y filtrado de datos.

### 2.3 Patrón del repositorio

Todo el acceso a datos se realiza a través de las interfaces del repositorio

Los enlaces se configuran en app/Providers/AppServiceProvider.php permitiendo el intercambio continuo de implementaciones para pruebas o migración de fuentes de datos

## 3. Flujo de datos de ventas

El flujo más crítico del sistema implica la recuperación de datos de ventas de la API externa.

Detalles de implementación:

    1. Comprobaciónd e autenticación en app/Http/Controllers/SalesController.php
    2. Filtrado a nivel de servicio en app/Services/VentasService.php
    3. Llamada a la API externa a nivel de repositorio (implementación en SalesRepository)

## 4. Modelo de autenticación

El sistema implementa un patrón de autenticación dual.

Claves de sesión gestionadas:
    - external_api_cookies: Matriz de cookies de API externas almacenadas en app/Http/Controllers/Auth/AuthExternalSessionController.php
    - external_api_authenticated: Valor booleano establecido en app/Http/Controllers/Auth/AuthExternalSessionController.php

La autenticación de API externa utiliza GuzzleHttp\Cookie\CookieJaren en app/Http/Controllers/Auth/AuthExternalSessionController.php para capturar y almacenar cookies del sistema externo.

## 5. Integración de API externa

La aplicación depende de una API externa http://localhost/daw2025/TP/Public con tres endpoints:

| Endpoint | Método | Propósito | Cuerpo de la solicitud |
|----------|--------|-----------|------------------------|
| /login | POST | Autenticar y recibir cookies | {"nombre_usuario": "...", "contrasena": "..."} |
| /ventas | GET | Recuperar todos los datos de ventas | Ninguno (se requieren cookies) |
| /usuarios | POST | Cargar usuario | Objeto de datos de usuario |

Ejemplo de solicitud de autenticación en app/Http/Controllers/Auth/AuthenticatedSessionController.php

```json
POST http://localhost/daw2025/TP/Public/login
Content-Type: application/json

{
    "nombre_usuario": "username",
    "contrasena": "password"
}
```

La API externa devuelve datos con nombres de campo en español que deben transformarse:
    - cuit_cliente -> cuitClient
    - fecha -> date
    - monto -> price

Esta transformación ocurre en SalesRepository antes de que los datos lleguen a la capa de servicio

## 6. Configuración inicial de datos

La aplicación genera datos de desarrollo a través de database/seeders/DatabaseSeeder.php

    1. 5 usuarios de prueba aleatorios generados por User::factory(5)
    2. 1 cuenta de administrador mediante AdminSeeder credenciales admin@example.com / admin123
    3. 6 clientes predefinidos con números CUIT realistas
        - Alba Inés (CUIT: 1209312094)
        - Juan Ignacio (CUIT: 20377138792)
        - Francisco Colombara (CUIT: 11111111111)
        - Mariana López (CUIT: 11111111115)
        - Sofía García (CUIT: 90333333339)
        - Milo J (CUIT: 99999999999)

Estos clientes se pueden utilizar para probar la recuperación de datos de ventas asumiendo que la API externa tiene registros de ventas correspondientes.

## 7. Estructura de enrutamiento

Las rutas se definen en rutas/web.php con la siguiente estructura:

| Patrón | Controlador | Middleware | Propósito |
|--------|-------------|------------|-----------|
| / | Redirección | Ninguno | Redirecciona a client.index |
| /dashboard | Redirección | auth, verified | Redirección posterior al inicio de sesión a clients.index |
| /users | UserController | auth | Rutas de recursos CRUD del usuario |
| /clients | ClientController | auth | Rutas de recursos CRUD del cliente |
| /clients/archived | ClientController::archived | auth | Lista de clientes eliminados temporalmente |
| /clients/restore/{id} | ClientController::restore | auth | Restaurar cliente eliminado |
| /clients/{client}/sales | ClientController::sales | auth | Redirigir a la vista de ventas |
| /sales/listSalesByCuit/{cuit} | SalesController::listSalesByCuit | Ninguno | Ventas de exhibición (sesión de cheques) |
| /profile | ProfileController | auth | Gestión de perfiles de usuario (Breeze) |

La ruta de ventas en la línea 56 no utiliza auth el middleware de Laravel, sino que verifica los valores de la sesión directamente en app/Http/Controllers/SalesController.php

## 8. Decisiones arquitectónicas clave

    1. Patrón de repositorio con interfaces: permite la abstracción de API externa y acceso a base de datos detrás de contratos uniformes.
    2. Capa de servicio para la lógica de negocios: separa la orquestación del manejo de HTTP y el acceso a los datos
    3. Autenticación dual: autenticación interna de Laravel + autenticación de API externa con estado basado en sesión
    4. Soft-delete para clientes: los clientes utilizan deleted_at timestamps, para la eliminación lógica con capacidad de restauración
    5. Ventas externas de solo lectura: los datos de ventas nunca se almacenan localmente, siempre se obtienen a pedido a una API externa
    6. Registro extenso: registros de depuración en app/Http/Controllers/SalesController.php y app/Services/VentasService.php para solucionar problemas de integración con API externa
    7. Almacenamiento de cookies basado en sesión: cookies de API externa almacenadas en la sesión de Laravel en lugar de pasarse explícitamente por el frontend

Estas decisiones priorizan la separación de tareas, la capacidad de prueba mediante la inyección de dependencia y la integración con un sistema externo que no se puede modificar.
