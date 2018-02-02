FROM php:7.1-cli-alpine

RUN docker-php-ext-install mysqli pdo pdo_mysql pcntl

ADD . /code
WORKDIR /code

EXPOSE 8000:8000

CMD ["php", "-S", "0.0.0.0:8000", "-t",  "/code/public/"]