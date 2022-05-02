<?php

namespace oct8pus\Invoice;

abstract class Entity
{
    protected ?Address $address;
    protected string $email;

    public function __construct()
    {
        $this->address = null;
    }

    public function __toString() : string
    {
        return $this->address;
    }

    public function setAddress(?Address $address) : self
    {
        $this->address = $address;
        return $this;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;
        return $this;
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

    public function address() : ?Address
    {
        return $this->address;
    }

    public function email() : string
    {
        return $this->email;
    }
}
