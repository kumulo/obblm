FROM php:7.4-fpm as php-symfony-base

RUN apt-get update && apt-get install -y \
    curl git libmcrypt-dev libpq-dev \
    libcurl4-gnutls-dev libicu-dev \
    libvpx-dev libjpeg-dev libpng-dev \
    libxpm-dev zlib1g-dev libfreetype6-dev \
    libxml2-dev libexpat1-dev libbz2-dev \
    libgmp3-dev libldap2-dev unixodbc-dev \
    libsqlite3-dev libaspell-dev libsnmp-dev \
    libpcre3-dev libtidy-dev libonig-dev \
    libzip-dev

# Install Node, Yarn
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs
RUN npm install -g yarn

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

# Install PHP extensions
RUN docker-php-ext-install mbstring \
    pdo \
    pdo_mysql \
    curl \
    json \
    intl \
    gd \
    xml \
    zip \
    bz2 \
    opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

EXPOSE 9000

RUN docker-php-ext-install pcntl
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN apt-get install -y supervisor

RUN docker-php-ext-install bcmath

RUN apt-get install -y \
    librabbitmq-dev \
    && pecl install -o -f amqp \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable amqp

WORKDIR /var/www/symfony

FROM php-symfony-base as php-symfony-dev

RUN pear upgrade pear
RUN pear install PHP_CodeSniffer

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
EXPOSE 80

FROM php-symfony-base as php-symfony-prod

COPY ./ /var/www/symfony
RUN composer install
