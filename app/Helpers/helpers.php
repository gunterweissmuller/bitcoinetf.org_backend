<?php

declare(strict_types=1);

use Elliptic\EC;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Validator;
use kornrunner\Keccak;

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
            if (!!$data) {
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

if (!function_exists('checkWalletConnectAuthorizationValidator')) {
    function checkWalletConnectAuthorizationValidator(Validator $validator, ?string $reqData): void
    {
        if (!!$reqData) {
            $data = json_decode($reqData, true);

            if (!!$data) {
                try {
                    $msgHash = Keccak::hash("\x19Ethereum Signed Message:\n" . strlen($data['message']) . $data['message'], 256);
                    $sig = [
                        'r' => substr($data['signature'], 2, 64),
                        's' => substr($data['signature'], 66, 64),
                        'v' => substr($data['signature'], 130, 2),
                    ];

                    $ec = new EC('secp256k1');
                    $pubKey = $ec->recoverPubKey($msgHash, $sig, hexdec($sig['v']) - 27);
                    $recoveredAddress = '0x' . substr(Keccak::hash(substr(hex2bin($pubKey->encode('hex')), 1), 256), 24);

                    if (strtolower($recoveredAddress) !== strtolower($data['address'])) {
                        $validator->errors()->add('wallet_connect_data', 'Signature is not correct');
                    }
                } catch (Exception $e) {
                    $validator->errors()->add('wallet_connect_data', 'Invalid signature');
                }
            } else {
                $validator->errors()->add('wallet_connect_data', 'WalletConnect data is empty');
            }
        }
    }
}
