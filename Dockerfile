# Imagem base com o PHP instalado
FROM php:8.1-cli

# Copie todos os arquivos do projeto para a pasta de trabalho /var/www/html
COPY . /var/www/html

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Instale as dependências do Composer
RUN apt-get update && apt-get install -y \
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instale as dependências do projeto
RUN composer install

# Exponha a porta 8000 para acessar o servidor embutido do PHP
EXPOSE 8000

# Comando para iniciar o servidor embutido do PHP
CMD php -S 0.0.0.0:8000 -t src/Presentation/API
