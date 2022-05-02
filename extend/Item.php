<?php

namespace oct8pus\Extend;

use oct8pus\Invoice\Item as BaseItem;

class Item extends BaseItem
{
    protected float $version;

    public function __construct(string $name, float $price, int $quantity, float $version)
    {
        parent::__construct($name, $price, $quantity);

        $this->version = $version;
    }

    public function version() : string
    {
        return number_format($this->version, 3, '.');
    }

    public function code(string $firstName, string $lastName) : string
    {
        return 'AAAA-BBBB-CCCC-DDDD';
    }
}
