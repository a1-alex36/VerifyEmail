# работает
FROM php:7.4-fpm

#git, curl, wget, grep
RUN apt-get update && apt-get install -y wget curl git grep
#RUN apt-get -y --force-yes install wget curl git unzip grep

# install composer
RUN apt-get update && apt-get install -y unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /app
