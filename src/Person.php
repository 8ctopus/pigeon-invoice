<?php

namespace oct8pus\Invoice;

use Locale;

class Person extends Entity
{
    protected string $firstName;
    protected string $lastName;

    public function __construct()
    {
        $this->firstName = '';
        $this->lastName = '';

        parent::__construct();
    }

    public function __toString() : string
    {
        return "{$this->firstName} {$this->lastName}\n" . $this->address;
    }

    public function isPerson() : bool
    {
        return true;
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    public function secondName() : string
    {
        return $this->lastName;
    }

    public function name() : string
    {
        switch (Locale::getDefault()) {
            case 'ja':
            case 'ru':
                return "{$this->lastName} {$this->firstName}";

            default:
                return "{$this->firstName} {$this->lastName}";
        }
    }

    public function setFirstName(string $firstName) : self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName(string $lastName) : self
    {
        $this->lastName = $lastName;
        return $this;
    }
}
