<?php

namespace oct8pus\Invoice;

class Address
{
    protected string $street1;
    protected string $street2;
    protected string $zip;
    protected string $city;
    protected string $country;

    public function __construct(string $street1, string $street2, string $zip, string $city, string $country)
    {
        $this->street1 = $street1;
        $this->street2 = $street2;
        $this->zip = $zip;
        $this->city = $city;
        $this->country = $country;
    }

    public function __toString() : string
    {
        $result = "{$this->street1}\n";

        if (!empty($this->street2)) {
            $result .= "{$this->street2}\n";
        }

        $result .= "{$this->zip} {$this->city}\n";
        $result .= "{$this->country}\n";

        return $result;
    }

    public function street1() : string
    {
        return $this->street1;
    }

    public function street2() : string
    {
        return $this->street2;
    }

    public function zip() : string
    {
        return $this->zip;
    }

    public function city() : string
    {
        return $this->city;
    }

    public function country() : string
    {
        return $this->country;
    }
}
