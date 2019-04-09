FROM php:7.2-fpm

RUN apt-get update \
    && apt-get install -y mysql-client curl \
    libmcrypt-dev openssh-client icu-devtools \
    libxml2-dev libfreetype6-dev libpng-dev \
    libjpeg-dev g++ make autoconf \
    && docker-php-source extract \
    && pecl install xdebug redis apcu \
    && docker-php-ext-enable xdebug redis apcu \
    && docker-php-source delete \
    && docker-php-ext-install pdo_mysql soap intl zip xml \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=10000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=PHP_STORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=172.18.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN useradd -rm -d /home/docker_user -s /bin/bash -g root -G sudo -u 1000 docker_user
USER docker_user
WORKDIR /var/www/html


CMD ["php-fpm", "-F"]

EXPOSE 9000