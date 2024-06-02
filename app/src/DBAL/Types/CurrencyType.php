<?php

namespace App\DBAL\Types;

class CurrencyType
{
    /**
     * @return array
     */
    public static function getChoices(): array
    {
        return [
            'USD' => 'USD',
            'EUR' => 'EUR',
            'RUB' => 'RUB',
            'CAD' => 'CAD',
        ];
    }

    /**
     * @param string $currency
     *
     * @return array
     */
    public static function getChoicesWithoutOne(string $currency): array
    {
        $currencies = static::getChoices();
        unset($currencies[$currency]);

        return $currencies;
    }
}