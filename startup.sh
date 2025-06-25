#!/bin/bash

echo "→ Laravel startup script iniciado"

# Moverse al directorio de trabajo
cd /home/site/wwwroot

# Mover el contenido de public/ a la raíz temporalmente
cp -r public/* .

echo "✔ Archivos públicos copiados a raíz"

# Opcional: limpiar rutas de entrada innecesarias
rm -rf public

echo "✅ Startup Laravel finalizado"
