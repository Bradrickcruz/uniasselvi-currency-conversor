<?php

require_once './controllers/CurrencyController.php';
require_once './utils/Helpers.php';

use Controllers\CurrencyController;
use Utils\Helpers;

$action = $_GET['action'] ?? null;

switch (strtolower($action)) {
    case 'convert':
        CurrencyController::convert();
        break;
    case 'list':
        CurrencyController::listRates();
        break;
    default:
        http_response_code(404);
        Helpers::sendResponse(['success' => false, 'message' => 'Endpoint não encontrado.']);
}
