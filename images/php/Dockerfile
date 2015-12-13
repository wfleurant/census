FROM php:5-fpm

RUN curl -sL https://deb.nodesource.com/setup | bash - && \
    apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        libmcrypt-dev nodejs libbz2-dev libpng12-dev php-pear \
        libssl-dev curl git php5-mcrypt php5-gd && \
    apt-get clean

RUN docker-php-ext-install \
        mcrypt mbstring tokenizer \
        bz2 gd zip pdo_mysql \
        mysqli pcntl bcmath

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer self-update

RUN npm install -g \
        bower \
        gulp \
        grunt grunt-cli

CMD ["php-fpm"]
