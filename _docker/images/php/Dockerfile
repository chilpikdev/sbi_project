FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    apt-utils \
    libpq-dev \
    libpng-dev \
    postgresql \
    libjpeg-dev \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libgd-dev \
    jpegoptim optipng pngquant gifsicle \
    libonig-dev \
    libxml2-dev \
    zip unzip && \
    docker-php-ext-install pdo_pgsql bcmath gd zip && \
    apt-get clean

WORKDIR /var/www/backend

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg

COPY ./_docker/images/php/conf.d/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./_docker/images/php/conf.d/php.ini /usr/local/etc/php/conf.d/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www/backend \
    && chmod -R 755 /var/www/backend

RUN mkdir -p /var/log/php-fpm
RUN chown -R www-data:www-data /var/log/php-fpm
RUN chmod -R 755 /var/log/php-fpm

USER www-data

EXPOSE 9000

CMD ["php-fpm"]
