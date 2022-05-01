<?php

namespace oct8pus\Invoice;

class Company extends Entity
{
    protected string $name;

    public function __construct(string $name, Address $address)
    {
        $this->name = $name;

        parent::__construct($address);
    }

    public function __toString() : string
    {
        return "{$this->name}\n" . $this->address;
    }

    public function addWebsite(string $website)
    {
        $this->website = $website;
    }

    public function isCompany() : bool
    {
        return true;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function firstName() : string
    {
        return $this->name;
    }

    public function secondName() : string
    {
        return $this->name;
    }

    public function website() : string
    {
        return $this->website;
    }
}
