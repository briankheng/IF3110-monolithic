FROM php:8.0-apache

# PHP extensions

RUN apt-get update

# Install Postgre PDO
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql
RUN a2enmod rewrite