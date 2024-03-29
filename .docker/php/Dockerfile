FROM php:8.1-fpm-buster
ARG TIMEZONE

ENV ACCEPT_EULA=Y

COPY savoirr-pool-1.conf /usr/local/etc/php-fpm.d/

RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN echo 'max_execution_time = 0' >> /usr/local/etc/php/conf.d/docker-php-maxexectime.ini;

RUN apt-get update && apt-get install -y \
    xclip \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    libcurl4 \
    libcurl4-openssl-dev \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

    # Install prerequisites required for tools and extensions installed later on.
RUN apt-get install -y apt-transport-https gnupg2 libpng-dev libzip-dev unzip \
    && rm -rf /var/lib/apt/lists/*

    # Retrieve the script used to install PHP extensions from the source container.
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install required PHP extensions and all their prerequisites available via apt.
RUN chmod uga+x /usr/bin/install-php-extensions \
    && sync \
    && install-php-extensions bcmath ds exif gd intl opcache pcntl redis zip

RUN pear config-set php_ini ${PHP_ROOT_DIR}/php/php.ini

COPY xdebug.ini /usr/local/etc/php/conf.d/

RUN docker-php-ext-configure gd --with-jpeg --with-freetype 

RUN docker-php-ext-install \
    curl pdo pdo_mysql xsl mbstring sockets

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh
ENTRYPOINT [ "/docker-entrypoint.sh" ]

# CMD composer update --no-plugins ; php-fpm