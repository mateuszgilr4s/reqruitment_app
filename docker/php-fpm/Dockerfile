FROM php:7.4-fpm as base

RUN apt update && apt install -y lsb-base \
    libzip-dev \
    zip \
    git \
    gettext-base \
    libpq-dev

RUN docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_pgsql
RUN apt clean \
  && rm -rf /var/lib/apt/lists/*

EXPOSE 9000
RUN mkdir -p /var/www/symfony && chown www-data:www-data /var/www/symfony
WORKDIR /var/www/symfony
FROM base as builder

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer --version=1.10.16 &&  mkdir /var/www/.composer && chown www-data:www-data  /var/www/.composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

USER www-data
RUN composer global require hirak/prestissimo
USER root

FROM builder as dev
RUN apt update \
    && apt install -y fish \
    && chsh -s `which fish`

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN apt clean \
  && rm -rf /var/lib/apt/lists/*

FROM builder as source

USER www-data

COPY --chown=www-data:www-data ./app/*.json ./app/*.lock ./

RUN composer check-platform-reqs \
    && composer install \
        --prefer-dist \
        --optimize-autoloader \
        --no-interaction \
        --no-scripts \
        --no-dev

COPY --chown=www-data:www-data ./app/bin ./bin
COPY --chown=www-data:www-data ./app/public ./public
#COPY --chown=www-data:www-data ./app/translations ./translations
COPY --chown=www-data:www-data ./app/config ./config
COPY --chown=www-data:www-data ./app/src ./src
RUN mkdir -p /var/www/symfony/var

COPY --chown=www-data:www-data ./app/.env .env
RUN bin/console assets:install -e prod --no-debug \
    && rm .env

FROM source as test

COPY ./docker/php-fpm/php-ini-overrides.ini /usr/local/etc/php/conf.d/99-php-ini-overrides.ini
COPY --chown=www-data:www-data ./app/symfony.lock symfony.lock
RUN composer check-platform-reqs \
    && composer install \
        --prefer-dist \
        --optimize-autoloader \
        --no-interaction \
        --no-scripts

#COPY --chown=www-data:www-data ./app/behat.yml.dist behat.yml.dist
#COPY --chown=www-data:www-data ./app/behat.yml.dist behat.yml
#COPY --chown=www-data:www-data ./app/features  ./features
COPY --chown=www-data:www-data ./app/.env .env
COPY --chown=www-data:www-data ./app/.php_cs.dist .php_cs

FROM base as prod

USER www-data

COPY --from=source --chown=www-data:www-data /var/www/symfony/ .
RUN touch /var/www/symfony/.env
COPY ./docker/php-fpm/php-ini-overrides.ini /usr/local/etc/php/conf.d/99-php-ini-overrides.ini
