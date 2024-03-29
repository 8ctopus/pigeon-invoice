<?php

declare(strict_types=1);

namespace Oct8pus\Invoice;

use Locale;

class Company extends Entity
{
    protected string $name;
    protected string $recipient;
    protected string $website;

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

    public function recipient() : string
    {
        return $this->recipient;
    }

    public function website() : string
    {
        return $this->website;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function setRecipient(string $firstName, string $lastName) : self
    {
        switch (Locale::getPrimaryLanguage(Locale::getDefault())) {
            case 'ja':
            case 'ru':
                $this->recipient = "{$lastName} {$firstName}";
                break;

            default:
                $this->recipient = "{$firstName} {$lastName}";
                break;
        }

        return $this;
    }

    public function setWebsite(string $website) : self
    {
        $this->website = $website;
        return $this;
    }
}
