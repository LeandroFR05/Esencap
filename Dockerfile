# ─── Stage 1: Compilar assets con Vite ────────────────────────────────────────
FROM node:22-alpine AS node-builder

WORKDIR /app

# Instalar pnpm
RUN npm install -g pnpm

# Copiar archivos de dependencias
COPY package.json pnpm-lock.yaml pnpm-workspace.yaml ./

# Instalar dependencias de Node
RUN pnpm install --frozen-lockfile

# Copiar código fuente necesario para el build
COPY vite.config.js ./
COPY resources/ resources/
COPY public/ public/

# Compilar assets para producción
RUN pnpm run build


# ─── Stage 2: PHP 8.2 + Nginx ─────────────────────────────────────────────────
FROM php:8.2-fpm-alpine

# ── Dependencias del sistema ───────────────────────────────────────────────────
RUN apk add --no-cache \
    nginx \
    curl \
    gettext \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# ── Composer ───────────────────────────────────────────────────────────────────
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ── Instalar dependencias PHP (capa cacheada) ──────────────────────────────────
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction

# ── Copiar el código de la aplicación ─────────────────────────────────────────
COPY . .

# ── Limpiar cache de bootstrap (referencias a paquetes dev del entorno local) ──
RUN rm -f bootstrap/cache/*.php

# ── Copiar los assets compilados por Vite (desde Stage 1) ─────────────────────
COPY --from=node-builder /app/public/build ./public/build

# ── Permisos ──────────────────────────────────────────────────────────────────
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# ── Nginx: eliminar config por defecto y copiar template ──────────────────────
RUN rm -f /etc/nginx/http.d/default.conf
COPY docker/nginx.conf /etc/nginx/http.d/nginx.conf.template

# ── Script de arranque ─────────────────────────────────────────────────────────
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
