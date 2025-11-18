# Imagen oficial de PHP + Apache
FROM php:8.2-apache

# Copiar los archivos del backend al servidor Apache
COPY . /var/www/html/

# Habilitar mod_rewrite (opcional, recomendado)
RUN a2enmod rewrite

# Exponer el puerto 80 (Render lo usa internamente)
EXPOSE 80
