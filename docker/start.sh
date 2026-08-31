#!/bin/sh
set -e

# ── Puerto dinámico de Render (default: 8080) ──────────────────────────────────
PORT=${PORT:-8080}
export PORT

echo "🚀 Iniciando EsenCap en el puerto $PORT..."

# ── Generar nginx.conf con el PORT correcto ────────────────────────────────────
envsubst '${PORT}' < /etc/nginx/http.d/nginx.conf.template > /etc/nginx/http.d/default.conf

# ── Bootstrap de Laravel ───────────────────────────────────────────────────────
echo "📦 Descubriendo paquetes..."
php artisan package:discover --ansi

echo "🔗 Creando enlace de storage..."
php artisan storage:link --force 2>/dev/null || true

echo "⚡ Cacheando configuración, rutas y vistas..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ── Migraciones ────────────────────────────────────────────────────────────────
echo "🗄️  Ejecutando migraciones y seeders..."
php artisan migrate --force
# php artisan migrate:fresh --force --seed

# ── Iniciar servicios ──────────────────────────────────────────────────────────
echo "✅ Iniciando PHP-FPM..."
php-fpm -D

echo "✅ Iniciando Nginx..."
exec nginx -g "daemon off;"
