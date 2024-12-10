<?php

namespace Models;

class Currency
{
    public $id;
    public $name;
    public $code;
    public $symbol;
    public $rate;
    public $updated_at;

    public function __construct($id, $name, $code, $symbol, $rate, $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->symbol = $symbol;
        $this->rate = $rate;
        $this->updated_at = $updated_at;
    }
}