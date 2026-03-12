FROM php:8.2-cli

RUN docker-php-ext-install pdo pdo_mysql mysqli

WORKDIR /var/www/html
COPY . /var/www/html/

ENV PORT=8080

CMD sh -c "php -S 0.0.0.0:${PORT} -t /var/www/html"