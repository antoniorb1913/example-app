# Usar la imagen PHP 8.2 FPM
FROM php:8.2-fpm 

# Instalar las dependencias del sistema
RUN apt-get update && apt-get install -y \ 
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev \ 
    nodejs npm \ 
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd intl \ 
    && apt-get clean && rm -rf /var/lib/apt/lists/* 

# Establecer el directorio de trabajo
WORKDIR /var/www 

# Copiar los archivos del proyecto
COPY . . 


# Instalar dependencias de Node
RUN npm install 
RUN npm run build 

# Exponer puerto
 EXPOSE 8000 

CMD php artisan serve --host=0.0.0.0 --port=8000