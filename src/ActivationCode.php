<?php

namespace oct8pus\Invoice;

class ActivationCode
{
    protected string $firstName;
    protected string $lastName;
    protected string $code;

    public function __construct(string $firstName, string $lastName, string $code)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->code = $code;
    }

    public function firstName() : string
    {
        return $this->name;
    }

    public function lastName() : string
    {
        return $this->price;
    }

    public function code() : string
    {
        return $this->code;
    }
}
