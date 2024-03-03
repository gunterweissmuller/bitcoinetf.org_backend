<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Validator;

if (!function_exists('transaction')) {
    function transaction(Closure $callback, int $attempts = 1): mixed
    {
        if (DB::transactionLevel() > 0) {
            return $callback;
        }

        return DB::transaction($callback, $attempts);
    }
}

if (!function_exists('checkTelegramAuthorizationValidator')) {
    function checkTelegramAuthorizationValidator(Validator $validator, ?string $reqData): void
    {
        if (!!$reqData) {
            $data = json_decode($reqData, true);
            $token = env('TELEGRAM_CLIENT_SECRET');
            if(!!$data) {
                $checkHash = $data['hash'];
                unset($data['hash']);
                $dataCheckArr = [];
                foreach ($data as $key => $value) {
                    $dataCheckArr[] = $key . '=' . $value;
                }
                sort($dataCheckArr);
                $dataCheckString = implode("\n", $dataCheckArr);
                $secretKey = hash('sha256', $token, true);

                $hash = hash_hmac('sha256', $dataCheckString, $secretKey);

                if (strcmp($hash, $checkHash) !== 0) {
                    $validator->errors()->add('telegram_data', 'Data is NOT from Telegram');
                }
                if ((time() - $data['auth_date']) > 86400) {
                    $validator->errors()->add('telegram_data', 'Data is outdated');
                }
            } else {
                $validator->errors()->add('telegram_data', 'Telegram data is empty');
            }
        }
    }
}
