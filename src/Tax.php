<?php

declare(strict_types=1);

namespace Oct8pus\Invoice;

class Tax
{
    protected string $name;
    protected float $percentage;

    public function __construct()
    {
        $this->name = '';
        $this->percentage = 0;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function percentage() : float
    {
        return $this->percentage;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function setPercentage(float $percentage) : self
    {
        $this->percentage = $percentage;
        return $this;
    }
}
