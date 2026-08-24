# ===== Stage 1: Composer依存関係のビルド =====
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --no-interaction

COPY . .

RUN composer dump-autoload --optimize --no-dev

# ===== Stage 2: 実行用イメージ =====
FROM php:8.3-fpm-alpine AS final

RUN apk add --no-cache \
        mysql-client \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && apk del .build-deps

RUN addgroup -g 1000 appuser && \
    adduser -D -u 1000 -G appuser appuser

WORKDIR /var/www/html

COPY --chown=appuser:appuser --from=vendor /app ./

RUN chmod -R 775 storage bootstrap/cache

USER appuser

HEALTHCHECK --interval=30s --timeout=3s --start-period=10s --retries=3 \
    CMD php artisan tinker --execute="exit(0);" || exit 1

EXPOSE 9000

CMD ["php-fpm"]