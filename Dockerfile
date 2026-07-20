FROM php:8.3-apache

# تثبيت المكتبات الأساسية وأدوات SQLite
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    libsqlite3-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql gd zip pdo_sqlite

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد Apache للعمل مع Laravel
RUN a2enmod rewrite
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# نسخ ملفات المشروع
COPY . /var/www/html

# إعداد العمل
WORKDIR /var/www/html

# تثبيت مكتبات المشروع
RUN composer install --no-dev --optimize-autoloader

# إنشاء ملف SQLite فارغ (في حال لم يكن مرفوعاً) وضبط صلاحيات المجلدات بدقة
RUN touch /var/www/html/database/database.sqlite
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database