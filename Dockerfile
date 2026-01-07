# Usar la imagen PHP 8.2 FPM
FROM php:8.2-fpm 

# 1. Instalar dependencias del sistema (añadida libpq-dev para Postgres)
RUN apt-get update && apt-get install -y \ 
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev libpq-dev \ 
    nodejs npm \ 
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl gd intl \ 
    && apt-get clean && rm -rf /var/lib/apt/lists/* # 2. INSTALAR COMPOSER (Esta es la línea que te faltaba antes del RUN composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www 

# Copiar los archivos del proyecto
COPY . . 

# 3. Ahora sí funcionará porque composer ya existe en la imagen
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Instalar dependencias de Node
RUN npm install 
RUN npm run build 

# Ajustar permisos para que Laravel pueda escribir
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer puerto
EXPOSE 8000 

CMD php artisan serve --host=0.0.0.0 --port=8000