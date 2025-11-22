# Documentación Trabajo Práctico 2 - DAW 2025

## 1. Visión General
Sistema de gestión de ventas y clientes creado con Laravel que se integra con una API externa para la recuperación de datos de los datos de las ventas a los distintos usuarios. La aplicación implementa una arquitectura en capas con una clara separación entre los controladores HTTP, la lógica del servicio y el acceso a los datos.

### 1.2 Propósito del sistema
La aplicación sirve como interfaz de gestión para tres entidades principales:

1. Clientes: Operaciones CRUD con soft-delete
2. Usuario: Carga de usuario
3. Ventas: Lectura de datos obtenidos de una API externa

El sistema requiere autenticación de doble capa: los usuarios deben autenticarse contra el sistema de autenticación interno de Laravel y autenticarse por separado con la API externa para acceder a los datos de ventas.

### Stack tecnológico
| Capa     | Tecnología                |
|----------|---------------------------|
| Backend | Laravel 11.x with PHP 8.2+ |
|----------|---------------------------|
| Frontend| Vite 5.x with Hot Moduel Replacement |
|----------|---------------------------|
| CSS Framework | Tailwind v3.x with v4 compatibility layer |
|----------|---------------------------|
| JavaScript | Alpine.js for reactive components, Axios for HTTP |
|----------|---------------------------|
| Data base | PostgreSQL/MySQL via Eloquent ORM |
|----------|---------------------------|
| HTTP Client | GuzzleHttp with CookieJar for external API |
|----------|---------------------------|
| Session Management | Laravel session with cookie storage |
|----------|---------------------------|
| Authentication | Laravel Breeze (internal) + external API auth |
|----------|---------------------------|