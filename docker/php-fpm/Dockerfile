FROM php:7.2-fpm

RUN apt-get update
RUN apt-get install -y zlib1g-dev libpq-dev git libicu-dev libxml2-dev unzip librabbitmq-dev libssh-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl bcmath sockets \
    && docker-php-ext-configure mysqli \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && docker-php-ext-install zip xml \
    && pecl install -o -f redis \
    && pecl install -o -f amqp \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis amqp

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Istanbul /etc/localtime
RUN "date"

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

WORKDIR /var/www/app