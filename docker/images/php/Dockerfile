FROM php:7.4-fpm-alpine
COPY ./php.ini usr/local/etc/php
RUN apk update
RUN apk --update add --no-cache librdkafka-dev
RUN apk add autoconf
RUN apk add libxml2-dev
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install xml
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install bcmath


#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV BUILD_DEPS 'autoconf git gcc g++ make bash openssh libssl1.1 openssl-dev'

RUN apk --no-cache upgrade \
    && apk add $BUILD_DEPS

RUN git clone --depth 1 --branch v1.8.2-RC5 https://github.com/edenhill/librdkafka.git \
    && cd librdkafka \
    && ./configure \
    && make \
    && make install

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer;

RUN pecl channel-update pecl.php.net \
    && pecl install rdkafka-4.0.2 \
    && docker-php-ext-enable rdkafka \
    && rm -rf /librdkafka \
    && apk del $BUILD_DEPS
