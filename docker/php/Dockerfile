FROM php:7.1-fpm

# Install modules
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng12-dev \
        libicu-dev \
        curl \
            --no-install-recommends

RUN curl -sL https://deb.nodesource.com/setup_6.x | bash - && apt-get install -y nodejs

RUN docker-php-ext-install intl mbstring pdo_mysql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install -o -f xdebug \
    && rm -rf /tmp/pear

COPY ./php.ini /usr/local/etc/php/
COPY ./www.conf /usr/local/etc/php/

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/*

RUN usermod -u 1000 www-data

EXPOSE 9000
CMD ["php-fpm"]
