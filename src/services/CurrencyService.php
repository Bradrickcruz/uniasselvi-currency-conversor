<?php

namespace Services;

require_once './src/repositories/CurrencyRepository.php';
require_once './src/utils/Helpers.php';

use Repositories\CurrencyRepository;
use Utils\Helpers;

class CurrencyService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new CurrencyRepository();
    }

    public function list(): array
    {
        return $this->repository->getAll();
    }

    public function convert(float $amount, string $from, string $to): float
    {
        $fromCurrency = $this->repository->getByCode($from);
        if (!$fromCurrency) {
            Helpers::sendResponse(['success' => false, 'message' => "Moeda de origem \"$from\" não encontrada."]);
        }

        $toCurrency = $this->repository->getByCode($to);
        if (!$toCurrency) {
            Helpers::sendResponse(['success' => false, 'message' => "Moeda de destino \"$to\" não encontrada."]);
        }

        return $amount * ($toCurrency->rate / $fromCurrency->rate);
    }
}
