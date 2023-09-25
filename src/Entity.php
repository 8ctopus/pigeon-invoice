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

    public function email() : string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;
        return $this;
    }

    public function type() : string
    {
        return substr(strrchr(static::class, '\\'), 1);
    }

    abstract public function name() : string;

    abstract public function firstName() : string;

    abstract public function secondName() : string;
}
