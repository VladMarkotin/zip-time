 FROM php:8.2-fpm

# # Установка расширений и инструментов, необходимых для работы composer и PHP
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# Сначала копируем только composer-файлы для кеширования слоёв
COPY composer.json ./

# Устанавливаем зависимости заранее, чтобы ускорить билды при изменении только исходников
#RUN composer install --no-interaction --prefer-dist

# Теперь копируем всё остальное приложение
#COPY . .

# Установи нужные расширения PHP для MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN docker-php-ext-install pdo pdo_mysql

# Добавь эти строки в Dockerfile после установки php/ext
RUN apt-get update \
  && apt-get install -y curl gnupg \
  && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
  && apt-get install -y nodejs \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

RUN chmod 644 /var/www/public/js/app.js \ 
     chmod 755 /var/www/public/js


EXPOSE 9000

CMD ["php-fpm"]
