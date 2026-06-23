# Как развернуть локально проект?

1. `cp .env.example .env` - скопировать `.env.example` в `.env`
2. Добавить `STRIPE_SECRET_KEY` в `.env`
3. `docker compose up -d`
4. `docker exec -it subscription-sync-dashboard-php-1 composer install`  
5. `docker exec -it subscription-sync-dashboard-php-1 php vendor/bin/phinx migrate`
6. для Linux:  
в `/etc/hosts` добавить запись:  
`127.0.0.1 subscription-sync-dashboard`
7. для Windows:   
в `C:\Windows\System32\drivers\etc\hosts` добавить запись:  
`127.0.0.1 subscription-sync-dashboard`

# Локальные домены
http://subscription-sync-dashboard - backend  
http://subscription-sync-dashboard:5173 - frontend

# Команды для разработки

(зайти в контейнер `subscription-sync-dashboard-php-1`)  

`php vendor/bin/phinx create <название_класса_миграции>` - создание миграции  
`php vendor/bin/phinx migrate` - выполнить миграции  
`php vendor/bin/phinx rollback` - откатить миграцию

# Для доступа к БД из DBeaver
Выставить `allowPublicKeyRetrieval` = true

# Что не сделано?

1. Изменение локальной базы, если в stripe произошло изменение. 
Обычно для такой задачи, в stripe или подобном сервисе настраиваются веб-хуки, а в проекте дописываются эндпоинты для обратной интеграции. 
Соответственно, чтобы они работали у проекта должен быть публичный домен.

# Что сделано не совсем правильно или можно улучшить?
1. Код стайл для Phalcon может отличаться от принятого в сообществе, потому что стек не мой.
2. Дублируется код соединения к БД в `public/index.php` и `config/config.php`
3. Получение данных в контролерах сделано без репозиториев
4. Роутинг в `config/routing.php` очень ручной, можно сделать лучше
5. Можно сделать DI обертку над интеграцией `StripeClient`
6. В проекте 1 коммит, обновлял код через `git commit --amend`, чтобы не засорять историю наработками
