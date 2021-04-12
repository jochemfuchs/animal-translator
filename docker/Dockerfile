FROM composer:latest as composerbase

ENV PHP_INI_DIR /usr/local/etc/php

FROM php:7.4-fpm
RUN apt-get update \
    && apt-get install -y locales zip zlib1g-dev libzip-dev libmagickwand-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mysqli pdo pdo_mysql bcmath zip pcntl exif intl \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd

# Set the locale
RUN sed -i -e 's/# \(en_US\.UTF-8 .*\)/\1/' /etc/locale.gen && \
    sed -i -e 's/# \(nl_NL\.UTF-8 .*\)/\1/' /etc/locale.gen && \
    locale-gen
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

###########################################################################
# xDebug:
###########################################################################
ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
  # Install the xdebug extension
  pecl install xdebug; \
  docker-php-ext-enable xdebug \
;fi

# Copy xdebug configuration for remote debugging
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini

COPY --from=composerbase /usr/bin/composer /usr/bin/composer
