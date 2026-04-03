FROM php:8.3-apache

# Activer le module rewrite d'Apache (utile pour les projets web)
RUN a2enmod rewrite

# Installer les extensions PHP courantes
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Le DocumentRoot par défaut d'Apache pointe vers /var/www/html
# On va le rediriger vers /var/www/projet via la config
COPY apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# Exposer le port 80
EXPOSE 80
