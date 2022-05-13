<?php

namespace Oct8pus\Invoice;

class Discount
{
    protected string $name;
    protected float $price;

    public function __construct()
    {
        $this->name = '';
        $this->price = 0;
    }

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
