# استخدم إصدار PHP 8.3 المتطابق مع جهازك
FROM php:8.3-apache

# تثبيت المكتبات الأساسية
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql gd zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد Apache للعمل مع Laravel (Public Directory)
RUN a2enmod rewrite
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# نسخ ملفات المشروع
COPY . /var/www/html

# ضبط صلاحيات المجلدات (ضروري جداً للارافيل)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# إعداد العمل
WORKDIR /var/www/html

# تثبيت مكتبات المشروع (Composer)
RUN composer install --no-dev --optimize-autoloader

# تعيين الصلاحيات النهائية
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache