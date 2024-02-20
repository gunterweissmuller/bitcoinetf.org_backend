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

## Restrictions!

- You cannot rename existing enum values in the database/code
- You cannot delete existing enums in tables
- If you are adding new fields to existing tables, make them nullable
- queues (and failed queues) are located in the tables: queue.jobs_fund and queue.failed_jobs_fund

