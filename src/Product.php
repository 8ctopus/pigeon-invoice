<?php

namespace oct8pus\Invoice;

class Product
{
    protected string $name;
    protected float $price;
    protected int $quantity;

    public function __construct(string $name, float $price, int $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function price() : float
    {
        return $this->price;
    }

    public function quantity() : float
    {
        return $this->quantity;
    }

    public function subtotal() : float
    {
        return $this->quantity * $this->price;
    }
}
