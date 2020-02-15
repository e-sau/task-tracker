FROM ubuntu:latest

RUN apt-get update

RUN apt-get -y install apache2 apache2-utils curl gnupg wget
RUN a2enmod rewrite

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get install -y git python3 perl \
    php nano

RUN apt-get install -y \
    php-pdo php-pdo-mysql \
    php-mbstring php-tokenizer \
    php-xml php-simplexml php-zip \
    php-opcache php-iconv php-intl \
    php-json php-gd php-ctype php-oauth \
    php-apcu php-imagick php-xdebug \
    php-memcached php-ftp php-imap \
    php-curl iputils-ping

RUN apt-get update

EXPOSE 80

ADD ./docker/conf/php/php.ini /etc/php/7.2/apache2/php.ini

ADD ./docker/conf/php/xdebug.ini /etc/php/7.2/mods-available/xdebug.ini

ADD ./docker/conf/apache/apache2.conf /etc/apache2/apache2.conf

RUN rm -R /etc/apache2/sites-enabled/* /etc/apache2/sites-available/* /var/www/*

WORKDIR /var/www

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]