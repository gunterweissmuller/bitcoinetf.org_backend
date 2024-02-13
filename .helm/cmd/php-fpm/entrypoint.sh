#!/bin/sh

set -e

if [ -z "$DB_PORT" ]; then
  echo >&2 'error: missing DB_PORT environment variable'
  exit 1
fi

if [ -z "$DB_HOST" ]; then
  echo >&2 'error: missing DB_HOST environment variable'
  exit 1
fi

if [ -z "$DB_DATABASE" ]; then
  echo >&2 'error: missing DB_DATABASE environment variable'
  exit 1
fi

if [ -z "$DB_USERNAME" ]; then
  echo >&2 'error: missing DB_USERNAME environment variable'
  exit 1
fi

if [ -z "$DB_PASSWORD" ]; then
  echo >&2 'error: missing DB_PASSWORD environment variable'
  exit 1
fi

php /var/www/html/artisan docs:swagger-build

exec "$@"
