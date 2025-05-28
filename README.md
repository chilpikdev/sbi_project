# SBI Project

Проект на Laravel с использованием Docker

## Требования

- Docker и Docker Compose
- Git

## Как развернуть проект

### 1. Клонируем проект
```bash
git clone https://github.com/chilpikdev/sbi_project.git
```

### 2. Заходим в папку
```bash
cd sbi_project
```

### 3. Создаём файл .env
```bash
cp .env.example .env
```

### 4. Даём нужные права
```bash
chmod -R 775 storage bootstrap/cache
```

### 5. Запускаем docker контейнеры
```bash
docker compose up -d
```

### 6. Открываем контейнер php
```bash
docker exec -it sbi_php bash
```

### 7. Выполняем следующие команды
```bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

## Дополнительная информация о контейнерах

- **sbi_nginx**: nginx контейнер (http://localhost:8000)
- **sbi_php**: php контейнер где работает сам проект
- **sbi_postgres**: база данных PostgreSQL, порт: 5432
- **sbi_pgadmin**: Панель управление для базы данных (http://localhost:8080)
- **sbi_redis**: служит для хранение кешов а также запуски очередей, порт: 6379
- **sbi_queue**: контейнер предназначен для автоматического запуска queue очередей

## Полезные команды

```bash
# Остановка контейнеров
docker compose down

# Просмотр логов
docker compose logs

# Перезапуск контейнеров
docker compose restart

# Вход в контейнер PHP
docker exec -it sbi_php bash
```

## Доступ к сервисам

После успешного запуска проекта:
- **Приложение**: http://localhost:8000
- **pgAdmin (управление БД)**: http://localhost:8080

## Работа с проектом

### Запуск тестов

```bash
docker exec -it sbi_php bash
touch database/testing.sqlite
php artisan test
```

### Работа с миграциями

```bash
php artisan migrate:fresh --seed
```

### Работа с очередями

Очереди запускаются автоматически в контейнере `sbi_queue`. Для ручного запуска:

```bash
docker exec -it sbi_php bash
php artisan queue:work
```

## Устранение неполадок

1. **Проблемы с правами доступа**: убедитесь, что директории `storage` и `bootstrap/cache` имеют права 775
2. **Ошибки подключения к базе данных**: проверьте настройки в файле `.env`
3. **Проблемы с контейнерами**: выполните `docker compose down` и `docker compose up -d`
