ARG PHP_VERSION=8.1
ARG NODE_VERSION=16
ARG INSTALL_BCMATH=true
ARG INSTALL_CALENDAR=false
ARG INSTALL_EXIF=false
ARG INSTALL_GD=false
ARG INSTALL_IMAGICK=false
ARG INSTALL_MOSQUITTO=false
ARG INSTALL_MYSQL=false
ARG INSTALL_OPCACHE=true
ARG INSTALL_PCNTL=true
ARG INSTALL_PGSQL=true
ARG INSTALL_REDIS=true
ARG INSTALL_SQLSRV=false
ARG INSTALL_XDEBUG=true
ARG INSTALL_ZIP=true


# Backend build
FROM ghcr.io/clevyr/php:$PHP_VERSION-base as php-builder
WORKDIR /app

COPY composer.json composer.lock auth.json ./
COPY nova-components/ nova-components/
RUN composer install \
        --ignore-platform-reqs \
        --no-autoloader \
        --no-interaction \
        --no-progress \
        --no-suggest

COPY . .
RUN set -x \
    && export TELESCOPE_ENABLED=false \
    && composer dump-autoload \
        --classmap-authoritative \
        --no-interaction \
    && php artisan nova:publish \
    && php artisan vendor:publish --tag=public


# Frontend build
FROM node:$NODE_VERSION-alpine as node-builder
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY --from=php-builder /app .
ARG NODE_ENV=production
RUN npm run build


# Local image
FROM ghcr.io/clevyr/php:$PHP_VERSION-onbuild as local-image
WORKDIR /app

ENV PHP_UPLOAD_MAX_FILESIZE=64m
ENV PHP_POST_MAX_SIZE=64m

COPY --chown=root docker/app/rootfs /
RUN crontab /etc/cron.d/scheduler

CMD ["s6-svscan", "/etc/s6/app"]


# Deployed image
FROM local-image

COPY --from=php-builder --chown=82:82 /app .
COPY --from=node-builder --chown=82:82 /app/public public/
