FROM php:8.2-cli

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    librabbitmq-dev \
    procps \
    && docker-php-ext-install pdo pdo_mysql zip pcntl sockets

# Instala extensão RabbitMQ
RUN pecl install amqp \
    && docker-php-ext-enable amqp

# Instala Node.js (LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Adicionar o diretório global do Composer ao PATH
ENV PATH="$PATH:/root/.composer/vendor/bin"

WORKDIR /var/www

# CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
CMD ["tail", "-f", "/dev/null"]
# CMD php -S 0.0.0.0:8000 -t public || tail -f /dev/null

