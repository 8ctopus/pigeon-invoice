<?php

namespace Oct8pus\Invoice;

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

    public function __toString() : string
    {
        return "{$this->name} {$this->quantity} * {$this->price}\n";
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

    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function setPrice(float $price) : self
    {
        $this->price = $price;
        return $this;
    }

    public function setQuantity(int $quantity) : self
    {
        $this->quantity = $quantity;
        return $this;
    }
}
