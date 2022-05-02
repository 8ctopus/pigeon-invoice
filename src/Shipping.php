<?php

namespace oct8pus\Invoice;

class Shipping
{
    protected string $name;
    protected float $price;

    public function name() : string
    {
        return $this->name;
    }

    public function price() : float
    {
        return $this->price;
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
}
