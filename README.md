# ETF

## Auth

For JWT to work, you need to create a private and public key in the `/storage/jwt` directory using the commands:

```shell
openssl ecparam -name prime256v1 -genkey -noout -out private.pem
openssl ec -in private.pem -pubout -out public.pem
```

## Queue

List of commands:

```shell
php artisan statistic:save-daily-wallet - [run once a day] collect statistics on the balance of users’ wallets
php artisan statistic:create-monthly-report - [run once a month] generation of a monthly account report
php artisan queue:work --tries=3 --queue=statistic.report.monthly_account_report - generating a monthly account report
php artisan kafka:consumer-process - starting the Kafka topic reading process
```

## Restrictions!

- You cannot rename existing enum values in the database/code
- You cannot delete existing enums in tables
- If you are adding new fields to existing tables, make them nullable
- queues (and failed queues) are located in the tables: queue.jobs_fund and queue.failed_jobs_fund

