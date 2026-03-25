FROM php:8.2-apache

# Cài đặt các thư viện cần thiết cho Extension PHP và Composer
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Bật module rewrite và cấu hình trực tiếp VirtualHost
RUN a2enmod rewrite
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html\n\
    <Directory /var/www/html>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Copy Composer từ image chính thức
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ code vào container
COPY . .

# Tự động tạo file .htaccess chuẩn (đã sửa lỗi ký tự $)
RUN printf "RewriteEngine On\n\
\n\
RewriteCond %%{REQUEST_FILENAME} !-f\n\
RewriteCond %%{REQUEST_FILENAME} !-d\n\
\n\
RewriteRule ^(.*)$ index.php?url=\$1 [QSA,L]" > .htaccess

# Cài đặt các thư viện PHP
RUN composer install --no-interaction --optimize-autoloader

# Phân quyền cho Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
