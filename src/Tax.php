<?php

namespace oct8pus\Invoice;

class Tax
{
    protected string $name;
    protected float $percentage;

    public function __construct(string $name, float $percentage)
    {
        $this->name = $name;
        $this->percentage = $percentage;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function percentage() : float
    {
        return $this->percentage;
    }
}
