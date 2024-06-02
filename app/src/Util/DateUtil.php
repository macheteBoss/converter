<?php

namespace App\Util;

use DateTime;

class DateUtil
{
    public const DATE_FORMAT = 'Y-m-d';

    /**
     * @return DateTime
     */
    public static function now(): DateTime
    {
        return new DateTime('now');
    }
}