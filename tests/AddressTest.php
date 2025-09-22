<?php

declare(strict_types=1);

namespace Tests;

use Oct8pus\Invoice\Address;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Address::class)]
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

        self::assertSame($address->street1(), $object->street1);
        self::assertSame($address->street2(), $object->street2);
        self::assertSame($address->zip(), $object->zip);
        self::assertSame($address->city(), $object->city);
        self::assertSame($address->country(), $object->country);

        self::assertSame(gettype((string) $address), 'string');
    }
}
