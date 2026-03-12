FROM php:8.2-apache

RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && a2enmod rewrite

ENV PORT=8080
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

COPY . /var/www/html/

EXPOSE 8080