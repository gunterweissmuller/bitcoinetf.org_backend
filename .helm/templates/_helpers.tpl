{{/* vim: set filetype=mustache: */}}
{{/*
Expand the name of the chart.
*/}}
{{- define "dev-env.name" -}}
{{- default .Chart.Name .Values.nameOverride | trunc 63 | trimSuffix "-" -}}
{{- end -}}

{{- define "kube-namespace" -}}
{{- printf "%s-%s" .Values.git.tag .Values.git.name | lower | trunc 63 | trimSuffix "-" -}}
{{- end -}}

{{- define "ingressDomain" -}}
{{- printf "%s.%s.%s" .Values.git.tag .Values.git.name .Values.devDomain | lower | trunc 255 | trimSuffix "-" -}}
{{- end -}}

{{- define "imagePullSecret" }}
{{- printf "{\"auths\": {\"%s\": {\"auth\": \"%s\"}}}" .Values.imageCred.registry (printf "%s:%s" .Values.imageCred.username .Values.imageCred.password | b64enc) | b64enc }}
{{- end -}}

{{/*
Create a default fully qualified app name.
We truncate at 63 chars because some Kubernetes name fields are limited to this (by the DNS naming spec).
If release name contains chart name it will be used as a full name.
*/}}
{{- define "dev-env.fullname" -}}
{{- if .Values.fullnameOverride -}}
{{- .Values.fullnameOverride | trunc 63 | trimSuffix "-" -}}
{{- else -}}
{{- $name := default .Chart.Name .Values.nameOverride -}}
{{- if contains $name .Release.Name -}}
{{- .Release.Name | trunc 63 | trimSuffix "-" -}}
{{- else -}}
{{- printf "%s-%s" .Release.Name $name | trunc 63 | trimSuffix "-" -}}
{{- end -}}
{{- end -}}
{{- end -}}

{{/*
Create chart name and version as used by the chart label.
*/}}
{{- define "dev-env.chart" -}}
{{- printf "%s-%s" .Chart.Name .Chart.Version | replace "+" "_" | trunc 63 | trimSuffix "-" -}}
{{- end -}}

{{- define "apps-env-var-values" -}}
{{- $globals := ternary .Values.global.stage (ternary .Values.global.prod .Values.global.dev (eq .Values.global.env_name "prod")) (eq .Values.global.env_name "stage") -}}

- name: APP_NAME
  value: "{{ upper .Values.global.app_name }}"
- name: APP_ENV
  value: "{{ .Values.global.env_full_name }}"
- name: APP_KEY
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: appKey
- name: APP_DEBUG
  value: "{{ $globals.app.debug }}"
- name: APP_URL
  value: https://{{ .Values.global.ci_url }}{{ .Values.global.ci_path | trimSuffix "/" }}

- name: LOG_CHANNEL
  value: "stack"
- name: LOG_DEPRECATIONS_CHANNEL
  value: "null"
- name: LOG_LEVEL
  value: "debug"

- name: DB_CONNECTION
  value: "pgsql"
- name: DB_DATABASE
  value: "{{ $globals.db.database }}"
- name: DB_HOST
  value: "{{ $globals.db.host }}"
- name: DB_PORT
  value: "{{ $globals.db.port }}"
- name: DB_USERNAME
  value: "{{ $globals.db.user }}"
- name: DB_PASSWORD
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: pgsqlPassword

- name: BROADCAST_DRIVER
  value: "log"
- name: CACHE_DRIVER
  value: "redis"
- name: FILESYSTEM_DISK
  value: "s3"
- name: QUEUE_CONNECTION
  value: "database"
- name: SESSION_DRIVER
  value: "redis"
- name: SESSION_LIFETIME
  value: "120"

- name: REDIS_HOST
  value: "{{ $globals.redis.host }}"
- name: REDIS_PASSWORD
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: redisPassword
- name: REDIS_PORT
  value: "{{ $globals.redis.port }}"
- name: REDIS_PREFIX
  value: "{{ $globals.redis.prefix }}"
- name: REDIS_TO_KAFKA_CHANNEL
  value: "{{ $globals.redis.kafka_channel }}"

- name: MAIL_MAILER
  value: "smtp"
- name: MAIL_HOST
  value: "{{ $globals.mail.host }}"
- name: MAIL_PORT
  value: "{{ $globals.mail.port }}"
- name: MAIL_USERNAME
  value: "{{ $globals.mail.username }}"
- name: MAIL_PASSWORD
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: mailPassword
- name: MAIL_ENCRYPTION
  value: "{{ $globals.mail.encryption }}"
- name: MAIL_FROM_ADDRESS
  value: "{{ $globals.mail.address }}"
- name: MAIL_FROM_NAME
  value: "{{ $globals.mail.name }}"

- name: AWS_ACCESS_KEY_ID
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: s3AccessKey
- name: AWS_SECRET_ACCESS_KEY
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: s3SecretKey
- name: AWS_DEFAULT_REGION
  value: "{{ $globals.aws.region }}"
- name: AWS_BUCKET
  value: "{{ $globals.aws.bucket }}"
- name: AWS_ENDPOINT
  value: "{{ $globals.aws.endpoint }}"
- name: AWS_USE_PATH_STYLE_ENDPOINT
  value: "true"

- name: JWT_TTL_ACCESS
  value: "{{ $globals.jwt.ttl.access }}"
- name: JWT_TTL_REFRESH
  value: "{{ $globals.jwt.ttl.refresh }}"

- name: CENTRIFUGAL_HOST
  value: "{{ $globals.centrifugal.host }}"
- name: CENTRIFUGAL_API_KEY
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: centrifugalApiKey
- name: CENTRIFUGAL_SECRET_KEY
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: centrifugalSecretKey

- name: GREENFIELD_HOST
  value: "{{ $globals.greenfield.host }}"
- name: GREENFIELD_API_KEY
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: greenfieldApiKey
- name: GREENFIELD_STORE_ID
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: greenfieldStoreId

- name: PAYMENT_HOST
  value: "{{ $globals.payment.host }}"
- name: PAYMENT_API_KEY
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: paymentApiKey
- name: PAYMENT_CALLBACK_KEY
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: paymentCallbackKey

- name: MAILCHIMP_API_KEY
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: mailchimpApiKey
- name: MAILCHIMP_SERVER_PREFIX
  value: "{{ $globals.mailchimp.server_prefix }}"
- name: MAILCHIMP_LIST_ID
  value: "{{ $globals.mailchimp.list_id }}"

- name: MERCHANT001_HOST
  value: "{{ $globals.merchant01.host }}"
- name: MERCHANT001_API_TOKEN
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: merchant01ApiKey

- name: KAFKA_BROKERS
  value: "{{ $globals.kafka.brokers }}"
- name: KAFKA_CONSUMER_GROUP_ID
  value: "{{ $globals.kafka.consumer }}"
- name: KAFKA_OFFSET_RESET
  value: "{{ $globals.kafka.reset }}"
- name: KAFKA_SASL_USERNAME
  value: "{{ $globals.kafka.username }}"
- name: KAFKA_SASL_PASSWORD
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: kafkaPassword

- name: GOOGLE_CLIENT_ID
  value: "{{ $globals.google_auth.client_id }}"
- name: GOOGLE_CLIENT_SECRET
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: googleSecret
- name: GOOGLE_REDIRECT_URI
  value: "{{ $globals.google_auth.redirect_uri }}"

- name: APPLE_REDIRECT_URI
  value: "{{ $globals.apple_auth.redirect_uri }}"
- name: APPLE_PRIVATE_KEY
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: applePrivateKey
- name: APPLE_TEAM_ID
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: appleTeamId
- name: APPLE_SERVICE_ID
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: appleServiceId
- name: APPLE_KEY_ID
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: appleKeyId
- name: APPLE_SECRET_KEY_FILE_PATH
  value: "{{ $globals.apple_auth.secret_key_file_path }}"
- name: APPLE_SECRET_KEY_FILE_NAME
  value: "{{ $globals.apple_auth.secret_key_file_name }}"

- name: TELEGRAM_BOT_NAME
  value: "{{ $globals.telegram_auth.bot_name }}"
- name: TELEGRAM_CLIENT_SECRET
  valueFrom:
    secretKeyRef:
      name: secrets-backend
      key: telegramSecret
- name: TELEGRAM_REDIRECT_URI
  value: "{{ $globals.telegram_auth.redirect_uri }}"

- name: APOLLO_PAYMENT_HOST
  value: "{{ $globals.apollo_payment.host_name }}"
- name: APOLLO_PAYMENT_PUBLIC_KEY
  value: "{{ $globals.apollo_payment.public_key }}"
- name: APOLLO_PAYMENT_PRIVATE_KEY
  value: "{{ $globals.apollo_payment.private_key }}"
- name: APOLLO_PAYMENT_BASIC_WALLET_POLYGON_USDT_ADDRESS
  value: "{{ $globals.apollo_payment.basic_wallet_polygon_usdt_address }}"
- name: APOLLO_PAYMENT_BASIC_WALLET_POLYGON_USDT_ADDRESS_ID
  value: "{{ $globals.apollo_payment.basic_wallet_polygon_usdt_address_id }}"
- name: APOLLO_PAYMENT_ADVANCED_BALANCE_ID
  value: "{{ $globals.apollo_payment.advanced_balance_id }}"

- name: FACEBOOK_CLIENT_ID
  value: "{{ $globals.facebook_auth.client_id }}"
- name: FACEBOOK_CLIENT_SECRET
  value: "{{ $globals.facebook_auth.client_secret }}"
- name: FACEBOOK_REDIRECT_URI
  value: "{{ $globals.facebook_auth.redirect_uri }}"

{{- end -}}
