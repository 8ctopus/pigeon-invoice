<?php

namespace oct8pus\Invoice;

class Item
{
    protected string $name;
    protected float $price;
    protected int $quantity;

    public function __construct()
    {
        $this->name = '';
        $this->price = 0;
        $this->quantity = 1;
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

    public function setName($name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function setPrice($price) : self
    {
        $this->price = $price;
        return $this;
    }

    public function setQuantity($quantity) : self
    {
        $this->quantity = $quantity;
        return $this;
    }
}
