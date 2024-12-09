<?php

require_once './src/controllers/CurrencyController.php';
require_once './src/utils/Helpers.php';

use Controllers\CurrencyController;
$controller = new CurrencyController();

$action = $_GET['action'] ?? '';

switch (strtolower($action)) {
    case 'convert':
        $controller->convert();
        break;
    case 'list':
        $controller->listCurrencies();
        break;
    default:
        include 'src/views/index.php';
        break;
}
