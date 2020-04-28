FROM php:7.4-fpm-alpine

ENV BENCH_HOME="/srv/bench"
ENV DOCKERIZE_VERSION v0.6.1

RUN apk --no-cache update \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && cd /srv && curl -sS https://getcomposer.org/installer | php \
    && mv /srv/composer.phar /usr/local/bin/composer \
    && mkdir -p $BENCH_HOME \
    && wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz


WORKDIR $BENCH_HOME

ADD ["./generate-data-fake.php", "./bench-php.php", "./composer.json", "./composer.lock", "./.docker/docker-entrypoint.sh", "$BENCH_HOME/"]

RUN composer install -o \
    && ls -l

ENTRYPOINT ["/bin/sh", "/srv/bench/docker-entrypoint.sh"]
