<?php

use Oct8pus\Invoice\Address;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Oct8pus\Invoice\Address
 */
final class AddressTest extends TestCase
{
    public function testBase() : void
    {
        $object = (object) [
            'street1' => '16 Leo Tolstoy Street',
            'street2' => '-',
            'zip' => '119021',
            'city' => 'Moscow',
            'country' => 'Russia',
        ];

        $address = (new Address())
            ->setStreet1($object->street1)
            ->setStreet2($object->street2)
            ->setZip($object->zip)
            ->setCity($object->city)
            ->setCountry($object->country);

        $this->assertEquals($address->street1(), $object->street1);
        $this->assertEquals($address->street2(), $object->street2);
        $this->assertEquals($address->zip(), $object->zip);
        $this->assertEquals($address->city(), $object->city);
        $this->assertEquals($address->country(), $object->country);

        $this->assertEquals(gettype((string) $address), 'string');
    }
}
