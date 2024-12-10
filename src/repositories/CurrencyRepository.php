<?php

namespace Repositories;

require_once './src/utils/Database.php';
require_once './src/models/CurrencyModel.php';

use Utils\Database;
use Models\Currency;
use PDO;

class CurrencyRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM currencies");
        $currencies = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $currencies[] = new Currency($row['id'], $row['name'], $row['code'], $row['symbol'], $row['rate'],$row['updated_at']);
        }
        return $currencies;
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM currencies WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Currency($row['id'], $row['name'], $row['code'], $row['symbol'], $row['rate'],$row['updated_at']);
        }
        return null;
    }

    public function getByCode($code)
    {
        $stmt = $this->db->prepare("SELECT * FROM currencies WHERE code = :code");
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Currency($row['id'], $row['name'], $row['code'], $row['symbol'], $row['rate'],$row['updated_at']);
        }
        return null;
    }

    public function add(Currency $currency)
    {
        $stmt = $this->db->prepare("INSERT INTO currencies (name, code, symbol) VALUES (:name, :code, :symbol, :rate)");
        $stmt->bindParam(':name', $currency->name);
        $stmt->bindParam(':code', $currency->code);
        $stmt->bindParam(':symbol', $currency->symbol);
        $stmt->bindParam(':rate', $currency->rate);
        $stmt->execute();
    }

    public function update(Currency $currency)
    {
        $stmt = $this->db->prepare("UPDATE currencies SET name = :name, code = :code, symbol = :symbol, rate = :rate WHERE id = :id");
        $stmt->bindParam(':name', $currency->name);
        $stmt->bindParam(':code', $currency->code);
        $stmt->bindParam(':symbol', $currency->symbol);
        $stmt->bindParam(':rate', $currency->rate);
        $stmt->bindParam(':id', $currency->id);
        $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM currencies WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}