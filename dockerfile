FROM php:8.2-cli

# Instala extensões necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia apenas os arquivos necessários primeiro para otimizar o cache do Docker
COPY composer.json composer.lock ./

# Instala dependências do Laravel sem copiar o projeto inteiro ainda
RUN composer install --no-scripts --no-autoloader

# Agora copia o restante do projeto
COPY . .

# Instala o autoload depois de copiar tudo
RUN composer dump-autoload --optimize

# Garante permissões para o storage e cache
RUN chmod -R 777 storage bootstrap/cache

# Comando padrão para subir o app
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
