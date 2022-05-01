<?php

namespace oct8pus\Invoice;

class Product
{
    protected string $name;
    protected float $price;
    protected int $quantity;
    protected float $version;

    public function __construct(string $name, float $price, int $quantity, float $version)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->version = $version;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function price() : float
    {
        return $this->price;
    }

    public function version() : string
    {
        return number_format($this->version, 3, '.');
    }

    public function quantity() : float
    {
        return $this->quantity;
    }

    public function subtotal() : float
    {
        return $this->quantity * $this->price;
    }

    public function code(string $firstName, string $lastName) : string
    {
        return 'AAAA-BBBB-CCCC-DDDD';
    }
}
