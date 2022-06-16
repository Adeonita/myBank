FROM php:7.4-fpm-alpine

WORKDIR /var/www/html/mybank_app

RUN apk update
RUN apk add libxml2-dev
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install xml
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html/mybank_app

RUN ls

RUN composer install

RUN ls

# COPY vendor ./

# RUN composer install --ignore-platform-reqs --prefer-dist --no-scripts --no-progress --no-interaction --no-dev --no-autoloader

# RUN composer dump-autoload --optimize --apcu --no-dev


# RUN pwd
# RUN ls
# RUN  composer in/stall 

# CMD  ["php-fpm", "composer install", "php artisan migrate", "php artisan db:seed" ]

# RUN ls 

# RUN cd mybank_app
# RUN pwd

# RUN ls 
