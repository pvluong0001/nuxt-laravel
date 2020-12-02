FROM php:7.4-fpm-alpine
WORKDIR /app

RUN apk update && apk add \
  git \
  wget \
  freetype \
  freetype-dev \
  libpng-dev \
  jpeg-dev \
  libzip-dev \
  zip \
  unzip \
  openssh \
  autoconf

RUN apk --update --no-cache add autoconf g++ make && \
    pecl install xdebug-2.9.2 && \
    docker-php-ext-enable xdebug && \
    apk del --purge autoconf g++ make

RUN  docker-php-ext-configure gd

RUN docker-php-ext-install gd opcache pdo_mysql && \
  docker-php-ext-configure zip && \
  docker-php-ext-install zip && \
  docker-php-ext-enable xdebug

ENV PHPREDIS_VERSION 3.0.0

RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/$PHPREDIS_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis

COPY ./docker-entrypoint.sh /docker-entrypoint.sh
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini
#COPY ./deploy-key/ /root/.ssh/

ARG DOCKER_UID
ARG DOCKER_GID
RUN if [ ${DOCKER_UID:-0} -ne 0 ] && [ ${DOCKER_GID:-0} -ne 0 ]; then \
    deluser www-data &&\
    if getent group www-data ; then delgroup www-data; fi &&\
    addgroup -g ${DOCKER_GID} www-data &&\
    adduser -u ${DOCKER_UID} -G www-data www-data --disabled-password &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data \
;fi

RUN apk add --no-cache openssl

ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz

#COPY ./crontab.txt /crontab.txt
#RUN /usr/bin/crontab /crontab.txt

EXPOSE 9000
