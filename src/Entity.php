<?php

declare(strict_types=1);

namespace Oct8pus\Invoice;

abstract class Entity extends Address
{
    protected string $email;

    public function __construct()
    {
        parent::__construct();

        $this->email = '';
    }

    public function __toString() : string
    {
        return parent::__toString();
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
