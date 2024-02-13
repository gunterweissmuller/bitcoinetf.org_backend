# ETF

## Auth

Для работы JWT требуется в директории `/storage/jwt` создать приватный и публичный ключ командами:

```shell
openssl ecparam -name prime256v1 -genkey -noout -out private.pem
openssl ec -in private.pem -pubout -out public.pem
```

## Queue

Список команд:

```shell
php artisan statistic:save-daily-wallet - [запуск раз в день] сбор статистики баланса кошельков юзеров
php artisan statistic:create-monthly-report - [запуск 1 раз в месяц] формирование месячного отчета об аккаунте
php artisan queue:work --tries=3 --queue=statistic.report.monthly_account_report - генерация месячного отчета по аккаунту
php artisan kafka:consumer-process - Запуск процесса чтения топика Kafka
```

## Ограничения!

- Нельзя переименовывать существующие enum значения в БД / коде
- Нельзя удалять существующие enum в таблицах
- Если вы осуществляете добавления новых полей в существующие таблицы - делайте их nullbable 
- очереди (и зафейленные очереди) находятся в таблицах: queue.jobs_fund и queue.failed_jobs_fund

