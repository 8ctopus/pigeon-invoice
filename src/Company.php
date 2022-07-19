<?php

namespace Oct8pus\Invoice;

use Locale;

class Company extends Entity
{
    protected string $name;
    protected string $recipient;

    public function __construct()
    {
        parent::__construct();

        $this->name = '';
        $this->recipient = '';
    }

    public function __toString() : string
    {
        return "{$this->name}\n" . parent::__toString();
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

    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function recipient() : string
    {
        return $this->recipient;
    }

    public function setRecipient(string $firstName, string $lastName) : self
    {
        switch (Locale::getPrimaryLanguage(Locale::getDefault())) {
            case 'ja':
            case 'ru':
                $this->recipient = "{$lastName} {$firstName}";

            default:
                $this->recipient = "{$firstName} {$lastName}";
        }

        return $this;
    }

    public function website() : string
    {
        return $this->website;
    }

    public function setWebsite(string $website) : self
    {
        $this->website = $website;
        return $this;
    }
}
