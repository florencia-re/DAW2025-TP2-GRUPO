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