<?php

namespace oct8pus\Extend;

use oct8pus\Invoice\Item as BaseItem;

class Item extends BaseItem
{
    protected float $version;

    public function __construct()
    {
        parent::__construct();
    }

    public function version() : string
    {
        return number_format($this->version, 3, '.');
    }

    public function code(string $firstName, string $lastName) : string
    {
        return 'AAAA-BBBB-CCCC-DDDD';
    }

    public function setVersion(float $version) : self
    {
        $this->version = $version;
        return $this;
    }
}
