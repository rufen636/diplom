#!/bin/bash

# Скрипт автоматического развертывания Laravel приложения
# Назначение: выполнение последовательности команд для обновления приложения

echo "🚀 Starting deployment process..."

# Переход в директорию проекта
cd /var/www/laravel-app

echo "📥 Pulling latest changes from repository..."
# Получение последних изменений из репозитория
git pull origin main

echo "📦 Installing PHP dependencies..."
# Установка PHP зависимостей (без dev-пакетов)
composer install --no-dev --optimize-autoloader

echo "🔨 Building frontend assets..."
# Установка Node.js зависимостей и сборка фронтенда
npm ci && npm run build

echo "🗃️ Running database migrations..."
# Выполнение миграций базы данных
php artisan migrate --force

echo "⚡ Caching configuration..."
# Кэширование конфигурации для повышения производительности
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔄 Reloading services..."
# Перезагрузка сервисов для применения изменений
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx

echo "✅ Deployment completed successfully!"
echo "📊 Application is now live and serving requests"
