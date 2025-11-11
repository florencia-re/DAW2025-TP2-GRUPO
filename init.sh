#!/bin/bash

echo "🚀 Iniciando proceso de inicialización de la aplicación Laravel..."

# 1. Levantar los servicios principales (db, redis, app, web, phpmyadmin)
echo "📦 Levantando servicios principales..."
docker compose up -d db redis app web phpmyadmin

# 2. Esperar a que MySQL esté completamente listo
echo "⏳ Esperando a que MySQL esté listo..."
docker compose exec -T db sh -c 'until mysqladmin ping -h localhost -u root -p${MYSQL_ROOT_PASSWORD} --silent; do sleep 2; done'
echo "✅ MySQL está listo"

# 3. Instalar dependencias de Composer
echo "📚 Instalando dependencias de Composer..."
docker compose run --rm composer

# 4. Ejecutar migraciones y seeders
echo "🗄️  Ejecutando migraciones y seeders..."
docker compose run --rm migrate

# 5. Instalar dependencias de npm y compilar assets
echo "🎨 Instalando dependencias de npm y compilando assets..."
docker compose run --rm npm

# 6. Limpiar caché de Laravel
echo "🧹 Limpiando caché de Laravel..."
docker compose exec -T app php artisan optimize:clear

echo "✨ ¡Inicialización completada!"
echo ""
echo "📍 Accesos:"
echo "   - Aplicación: http://localhost:8000"
echo "   - phpMyAdmin: http://localhost:8081"
echo "   - MySQL: localhost:3309"
echo ""
echo "🔑 Credenciales de base de datos:"
echo "   - Usuario: user1"
echo "   - Contraseña: 1234"
echo "   - Base de datos: dawtp2"
