FROM node:20 AS frontend-builder

ARG MODE=production # Por defecto prod; pasa --build-arg MODE=development para dev

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install
COPY . .
#Condicional build para prod, nada para dev
RUN if [ "$MODE" = "production" ]; then npm run build; fi


# Usamos una imagen base de PHP con Apache (versión compatible con Laravel)
FROM php:8.2-apache

#Instalamos dependencias del sistema necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \ 
    default-mysql-client \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli exif pcntl bcmath intl \
    && a2enmod rewrite

# Instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Directorio de trabajo
WORKDIR /var/www/html

# Configurar VirtualHost de Apache para Laravel
COPY apache-laravel.conf /etc/apache2/sites-available/000-default.conf

# Copiamos el codigo de la app al contenedor
COPY . . 

COPY --from=frontend-builder /app/public/build /var/www/html/public/build

#Instalamos las dependencias de Composer
RUN composer install --optimize-autoloader --no-dev

#Generamos la clave de app de Laravel y configuramos permisos
RUN php artisan key:generate
RUN chown -R www-data:www-data storage bootstrap/cache

#Exponemos el puerto 80 para el servidor web
EXPOSE 80

#Copiando y configurando entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh


ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
