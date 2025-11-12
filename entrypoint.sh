#!/bin/bash

#Genera la clave si no existe
php artisan key:generate --ansi

sleep 5

i=0
#Esperar a que se buildee la base de datos
until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" --skip-ssl -e "SELECT 1" > /dev/null 2>&1; do
    i=$((i+1))
    echo "Intento $i: Esperando a que la base de datos esté lista..."
    sleep 3
done
echo "Base de datos lista."

php artisan config:clear


#ejecutar migraciones y seeders
php artisan migrate --force
php artisan db:seed --force

php artisan cache:clear

#Configurar permisos
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

exec "$@"

