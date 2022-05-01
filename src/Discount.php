<?php

namespace oct8pus\Invoice;

class Discount
{
    protected string $name;
    protected float $price;

    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function price() : float
    {
        return $this->price;
    }
}
