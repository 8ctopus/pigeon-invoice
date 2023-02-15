<?php

use Oct8pus\Invoice\Address;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
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

        static::assertSame($address->street1(), $object->street1);
        static::assertSame($address->street2(), $object->street2);
        static::assertSame($address->zip(), $object->zip);
        static::assertSame($address->city(), $object->city);
        static::assertSame($address->country(), $object->country);

        static::assertSame(gettype((string) $address), 'string');
    }
}
