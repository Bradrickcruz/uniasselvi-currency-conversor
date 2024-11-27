<?php

require_once './controllers/CurrencyController.php';
require_once './utils/Helpers.php';

use Controllers\CurrencyController;

$action = $_GET['action'] ?? '';

switch (strtolower($action)) {
    case 'convert':
        CurrencyController::convert();
        break;
    case 'list':
        CurrencyController::listRates();
        break;
    default:
        include 'views/index.php';
        break;
}
