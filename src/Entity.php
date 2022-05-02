<?php

namespace oct8pus\Invoice;

abstract class Entity extends Address
{
    protected string $email;

    public function __construct()
    {
        parent::__construct();
    }

    public function __toString() : string
    {
        return $this->address;
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

    public function email() : string
    {
        return $this->email;
    }
}
