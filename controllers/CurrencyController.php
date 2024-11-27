<?php

namespace Controllers;

require_once './services/CurrencyService.php';
require_once './utils/Helpers.php';

use Services\CurrencyService;
use Utils\Helpers;

class CurrencyController
{
    public static function convert(): void
    {
        $params = Helpers::validateGETParams([
            'from' => 'string',
            'to' => 'string',
            'amount' => 'float'
        ]);

        $from = strtoupper($params['from']);
        $to = strtoupper($params['to']);
        $amount = $params['amount'];

        $convertedValue = CurrencyService::convert($amount, $from, $to);
        Helpers::sendResponse(['success' => true, 'converted' => $convertedValue]);
    }

    public static function listRates(): void
    {
        $rates = Helpers::loadRatesJSON();
        $currencies = Helpers::loadCurrenciesJSON();
        Helpers::sendResponse(['success' => true, 'rates' => $rates, 'currencies'=> $currencies]);
    }
}
