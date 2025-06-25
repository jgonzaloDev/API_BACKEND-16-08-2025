#!/bin/bash

cd /home/site/wwwroot

# Mover contenido público al raíz
if [ -d "public" ]; then
  cp -r public/* .
fi

# Establecer permisos (por si acaso)
chmod -R 755 .

# Limpiar cachés
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generar clave si no existe
if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
fi
