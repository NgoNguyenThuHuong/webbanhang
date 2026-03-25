FROM php:8.2-apache

# Cài đặt các thư viện cần thiết cho Extension PHP và Composer
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Bật module rewrite và cấu hình AllowOverride All để nhận diện .htaccess
RUN a2enmod rewrite
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy Composer từ image chính thức
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ code vào container
COPY . .

# Sửa lại RewriteBase trong .htaccess cho phù hợp với môi trường Render
RUN if [ -f .htaccess ]; then sed -i 's/RewriteBase \/webbanhang\//RewriteBase \//g' .htaccess; fi

# Cài đặt các thư viện PHP
RUN composer install --no-interaction --optimize-autoloader

# Phân quyền cho Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
