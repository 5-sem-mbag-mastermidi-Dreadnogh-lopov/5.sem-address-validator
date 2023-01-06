FROM php:8.0-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libcurl4-nss-dev \
    libc-client-dev \
    libkrb5-dev \
    libicu-dev \
    libxml2-dev \
    libxslt1-dev \
    autoconf \
    zip \
    cron \
    git \
    libssh2-1-dev \
    libzip-dev \
    libonig-dev \
    redis \
    ghostscript

RUN docker-php-ext-install -j$(nproc) bcmath
RUN docker-php-ext-install -j$(nproc) sockets
RUN docker-php-ext-install -j$(nproc) mbstring
RUN docker-php-ext-install -j$(nproc) iconv
RUN docker-php-ext-install -j$(nproc) intl
RUN docker-php-ext-install -j$(nproc) soap
RUN docker-php-ext-install -j$(nproc) xsl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl
RUN docker-php-ext-install imap
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install opcache


RUN mkdir -p /usr/src/php/ext/xmlrpc \
    && curl -fsSL https://pecl.php.net/get/xmlrpc | tar xvz -C "/usr/src/php/ext/xmlrpc" --strip 1 \
    &&  docker-php-ext-install -j$(nproc) xmlrpc

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis \
    &&  docker-php-ext-enable sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer


COPY /.deployments/production/docker/fpm/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY /.deployments/production/docker/fpm/conf.d/zz-fpm-custom.ini /usr/local/etc/php-fpm.d/zz-fpm-custom.conf

COPY ./ /var/www/html
WORKDIR /var/www/html


# install all PHP dependencies
RUN composer install --no-interaction



