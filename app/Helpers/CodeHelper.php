<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Str;

final class CodeHelper
{
    private const LENGTH = 6;

    public const TYPE_NUM = 'num';

    public const TYPE_WEB3 = 'web3';

    public static function generate(int $length = self::LENGTH, string $type = self::TYPE_NUM): string
    {
        $code = '';

        if ($type == self::TYPE_NUM) {
            for ($i = 0; $i < $length; ++$i) {
                $code .= (string) mt_rand(0, 9);
            }
        }

        if ($type == self::TYPE_WEB3) {
            $code = Str::random($length);
        }

        return $code;
    }

    public static function generatePromoCode(): string
    {
        $symbols = [
            'A', 'B', 'C', 'D', 'E',
            'F', 'G', 'H', 'I', 'K',
            'L', 'M', 'N', 'O', 'P',
            'Q', 'R', 'S', 'T', 'V',
            'X', 'Y', 'Z'
        ];

        $code = '';

        for ($i = 0; $i < 5; $i++) {
            $code .= $symbols[array_rand($symbols)];
        }

        for ($i = 0; $i < 3; $i++) {
            $code .= mt_rand(0, 9);
        }

        return $code;
    }
}
