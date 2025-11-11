#!/bin/bash
set -e

echo "🚀 Iniciando contenedor Laravel..."

cd /var/www

# Esperar a que MySQL esté disponible
echo "⏳ Esperando a que la base de datos esté lista..."
until php artisan db:show 2>/dev/null | grep -q "Connection"; do
    echo "   Esperando conexión a MySQL..."
    sleep 2
done
echo "✅ Base de datos conectada"

# Instalar dependencias de Composer si no existen o composer.lock cambió
if [ ! -d "vendor" ] || [ "composer.lock" -nt "vendor/autoload.php" ]; then
    echo "📦 Instalando dependencias de Composer..."
    composer install --no-interaction --optimize-autoloader
    echo "✅ Dependencias de Composer instaladas"
else
    echo "✅ Dependencias de Composer ya instaladas"
fi

# Instalar dependencias de npm si no existen o package-lock.json cambió
if [ -f "package.json" ]; then
    if [ ! -d "node_modules" ] || [ "package.json" -nt "node_modules/.package-lock.json" ]; then
        echo "📦 Instalando dependencias de npm..."
        npm install
        echo "✅ Dependencias de npm instaladas"
        
        echo "🎨 Compilando assets..."
        npm run build
        echo "✅ Assets compilados"
    else
        echo "✅ Dependencias de npm ya instaladas"
    fi
fi

# Generar APP_KEY si no existe
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo "🔑 Generando APP_KEY..."
    php artisan key:generate --force
    echo "✅ APP_KEY generada"
fi

# Ejecutar migraciones (solo si hay archivos de migración pendientes)
echo "🗄️  Ejecutando migraciones..."
php artisan migrate --force

if [ $? -eq 0 ]; then
    echo "✅ Migraciones ejecutadas correctamente"
else
    echo "⚠️  Error al ejecutar migraciones"
fi

# Ejecutar seeders solo en primera ejecución (si hay un archivo flag)
if [ ! -f "/tmp/.seeded" ]; then
    echo "🌱 Ejecutando seeders..."
    php artisan db:seed --force
    touch /tmp/.seeded
    echo "✅ Seeders ejecutados"
fi

# Limpiar y optimizar caché
echo "🧹 Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Caché optimizado"

# Ajustar permisos de storage y bootstrap/cache
echo "🔧 Ajustando permisos..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
echo "✅ Permisos ajustados"

echo "✨ Contenedor listo!"
echo ""

# Ejecutar el comando pasado al contenedor (por defecto php-fpm)
exec "$@"
