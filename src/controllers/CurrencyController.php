<?php

namespace Controllers;

require_once './src/services/CurrencyService.php';
require_once './src/utils/Helpers.php';

use Services\CurrencyService;
use Utils\Helpers;

class CurrencyController
{
    private $service;

    public function __construct()
    {
        $this->service = new CurrencyService();
    }
    public function convert(): void
    {
        $params = Helpers::validateGETParams([
            'from' => 'string',
            'to' => 'string',
            'amount' => 'float'
        ]);

        $from = strtoupper($params['from']);
        $to = strtoupper($params['to']);
        $amount = $params['amount'];

        $convertedValue = $this->service->convert($amount, $from, $to);
        Helpers::sendResponse(['success' => true, 'converted' => $convertedValue]);
    }

    public function listCurrencies(): void
    {
        $currencies = $this->service->list();
        Helpers::sendResponse(jsonBody: ['success' => true, 'currencies' => $currencies]);
    }
}
