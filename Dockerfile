FROM php:8.1-cli

COPY . /var/www/html

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

EXPOSE 8000

RUN rm -rf database.sqlite.sqlite3

RUN touch database.sqlite.sqlite3

CMD [ "sh", "-c", "vendor/bin/phinx migrate -c src/Infrastructure/Database/phinx.php && php -S 0.0.0.0:8000 -t src/Presentation/API" ]
