<?php

namespace App\Helpers;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

class PhoneUtil
{
    public static function check(string $number, string $country_code = 'GH', ): string
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $number = $phoneUtil->parse($number, $country_code);
        $formattedNumber = $phoneUtil->format($number, PhoneNumberFormat::E164);

        return str_replace($formattedNumber, '+', '');
    }
}
