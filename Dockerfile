# Imagen oficial de PHP + Apache
FROM php:8.2-apache

# Copiar *solo* la carpeta Api al servidor Apache
COPY api/ /var/www/html/

# Activar mod_rewrite
RUN a2enmod rewrite
