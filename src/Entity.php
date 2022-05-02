<?php

namespace oct8pus\Invoice;

abstract class Entity
{
    protected Address $address;
    protected string $email;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function __toString() : string
    {
        return $this->address;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function isCompany() : bool
    {
        return false;
    }

    public function isPerson() : bool
    {
        return false;
    }

    abstract public function name() : string;

    abstract public function firstName() : string;

    abstract public function secondName() : string;

    public function address() : Address
    {
        return $this->address;
    }

    public function email() : string
    {
        return $this->email;
    }
}
