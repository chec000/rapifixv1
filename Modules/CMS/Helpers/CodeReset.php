<?php

namespace Modules\CMS\Helpers;

use Carbon\Carbon;

class CodeReset
{
    public static function getCodeReset($data)
    {
        $code           = '';
        $codeAlphabet   = $data['distId'] . str_replace(' ', '', str_replace(':', '', str_replace('-', '', Carbon::now())));
        $length         = $data['length'];
        $max            = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++)
        {
            $code   .= $codeAlphabet[self::crypto_rand_secure(0, $max - 1)];
        }

        return $code;
    }

    public static function crypto_rand_secure($min, $max)
    {
        $range  = $max - $min;

        if ($range < 1)
            return $min;

        $log    = ceil(log($range, 2));
        $bytes  = (int) ($log / 8) + 1;
        $bits   = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;

        do
        {
            $rnd    = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd    = $rnd & $filter;
        }
        while ($rnd > $range);

        return $min + $rnd;
    }
}