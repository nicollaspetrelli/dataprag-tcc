FROM php:8.0.12-fpm
WORKDIR "/var/www"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Args
ARG XDEBUG_ENABLED=true

# Install PHP extensions
RUN buildDeps="libpq-dev libzip-dev libicu-dev libpng-dev libjpeg-dev libfreetype6-dev libmagickwand-dev libxslt-dev apt-utils locales" && \
    apt-get update && apt-get install -y $buildDeps --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install \
        zip \
        pdo \
        pdo_mysql \
        gd 

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install language support on linux pt_BR and en_US to make php time functions work
RUN locale-gen en_US.UTF-8 && locale-gen pt_BR.UTF-8 && dpkg-reconfigure locales

RUN echo 'pt_BR.UTF-8 UTF-8' >> /etc/locale.gen && \
    echo 'en_US.UTF-8 UTF-8' >> /etc/locale.gen  && \
    locale-gen

# Install Xdebug
RUN if [ ${XDEBUG_ENABLED} = true ]; then \
    yes | pecl install xdebug \
    && docker-php-ext-enable xdebug \
    ;fi


# Install Imackig
RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

# install imagick
# Version is not officially released https://pecl.php.net/get/imagick but following works for PHP 8
RUN mkdir -p /usr/src/php/ext/imagick; \
    curl -fsSL https://github.com/Imagick/imagick/archive/06116aa24b76edaf6b1693198f79e6c295eda8a9.tar.gz | tar xvz -C "/usr/src/php/ext/imagick" --strip 1; \
    docker-php-ext-install imagick;

# Install composer dependencies

# COPY . .

# RUN rm -rf vendor/

# RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# RUN cp vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64 /usr/local/bin/
# RUN chmod +x /usr/local/bin/wkhtmltopdf-amd64