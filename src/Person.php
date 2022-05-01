<?php

namespace oct8pus\Invoice;

class Person extends Entity
{
    protected string $firstName;
    protected string $lastName;

    public function __construct(string $firstName, string $lastName, Address $address)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;

        parent::__construct($address);
    }

    public function __toString() : string
    {
        return "{$this->firstName} {$this->lastName}\n" . $this->address;
    }

    public function isPerson() : bool
    {
        return true;
    }

    public function name() : string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    public function secondName() : string
    {
        return $this->lastName;
    }
}
