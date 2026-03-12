<<<<<<< HEAD
FROM php:8.2-apache

RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && a2enmod rewrite

<<<<<<< HEAD
COPY . /var/www/html/
=======
=======
FROM php:8.2-apache

RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && a2enmod rewrite

>>>>>>> 99aebbc (fix apache mpm and dockerfile)
COPY . /var/www/html/
>>>>>>> dfeea55 (fix apache mpm and dockerfile)
