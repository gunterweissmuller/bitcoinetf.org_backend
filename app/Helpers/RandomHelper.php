<?php

declare(strict_types=1);

namespace App\Helpers;

final class RandomHelper
{
    public static function randFloat(float $min, float $max): float
    {
        [$minL, $minR] = count(explode('.', (string)$min)) > 1 ?
            explode('.', (string)$min) :
            explode('.', ((string)$min) . '.0');

        [$maxL, $maxR] = count(explode('.', (string)$max)) > 1 ?
            explode('.', (string)$max) :
            explode('.', ((string)$max) . '.0');

        if ((int)$minL === (int)$maxR) {
            $l = $minL;
            $r = rand((int)$minR, (int)$maxR);
        } else {
            $l = rand((int)$minL, (int)$maxL);

            if ($l === (int)$maxL) {
                $r = rand(0, (int)$maxR);
            } else {
                $r = rand(0, 99);
            }
        }

        return (float)(((string)$l) . '.' . ((string)$r));
    }
}
