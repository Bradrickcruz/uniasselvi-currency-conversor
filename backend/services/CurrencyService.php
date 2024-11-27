<?php

namespace Services;

require_once './utils/Helpers.php';

use Utils\Helpers;

class CurrencyService
{
    public static function convert(float $amount, string $from, string $to): float
    {
        $rates = Helpers::loadRatesJSON();

        if (!array_key_exists($from, $rates)) {
            Helpers::sendResponse(['success' => false, 'message' => "Moeda de origem \"$from\" não encontrada."]);
        }

        if (!array_key_exists($to, $rates)) {
            Helpers::sendResponse(['success' => false, 'message' => "Moeda de destino \"$to\" não encontrada."]);
        }

        return $amount * ($rates[$to] / $rates[$from]);
    }
}
