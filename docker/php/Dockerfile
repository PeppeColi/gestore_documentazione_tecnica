FROM php:7.4-fpm

RUN echo "Europe/Rome" > /etc/timezone

RUN apt-get update  \
    && apt-get upgrade -y  \
    && apt-get install -y \
        apt-utils \
        libmcrypt-dev \
        libfreetype6-dev \
        libzip-dev \
        zip \
        git \
        wget \
        libjpeg62-turbo-dev \
        libpng-dev \
        iputils-ping \
        net-tools \
        exif \
        locales \
        sqlite3 \
        zlib1g-dev \
        libnss3-dev \
    	npm

RUN docker-php-ext-install tokenizer mysqli pdo_mysql exif bcmath zip sockets \
	&& docker-php-ext-configure zip

COPY ./laravel.ini /usr/local/etc/php/conf.d/laravel.ini

ARG LOCAL_USER_ID=501
RUN deluser www-data
RUN adduser -q --home /home/www-data -uid "${LOCAL_USER_ID}" --shell /bin/bash www-data

COPY ./bashrc /home/www-data/.bashrc
