<?php

declare(strict_types=1);

use Oct8pus\Invoice\Person;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Oct8pus\Invoice\Entity
 * @covers \Oct8pus\Invoice\Person
 */
final class PersonTest extends TestCase
{
    public function testBase() : void
    {
        $object = (object) [
            'firstName' => 'Yuri',
            'lastName' => 'Kamasov',
            'street1' => '16 Leo Tolstoy Street',
            'street2' => '',
            'zip' => '119021',
            'city' => 'Moscow',
            'country' => 'Russia',
            'email' => 'test@yandex.ru',
        ];

        $person = (new Person())
            ->setFirstName($object->firstName)
            ->setLastName($object->lastName)
            ->setStreet1($object->street1)
            ->setStreet2($object->street2)
            ->setZip($object->zip)
            ->setCity($object->city)
            ->setCountry($object->country)
            ->setEmail($object->email);

        self::assertTrue($person->isPerson());
        self::assertFalse($person->isCompany());

        Locale::setDefault('en');

        self::assertSame($person->firstName(), $object->firstName);
        self::assertSame($person->secondName(), $object->lastName);
        self::assertSame($person->name(), "{$object->firstName} {$object->lastName}");

        Locale::setDefault('ru');

        self::assertSame($person->name(), "{$object->lastName} {$object->firstName}");

        self::assertSame($person->street1(), $object->street1);
        self::assertSame($person->street2(), $object->street2);
        self::assertSame($person->zip(), $object->zip);
        self::assertSame($person->city(), $object->city);
        self::assertSame($person->country(), $object->country);
        self::assertSame($person->email(), $object->email);

        self::assertSame(gettype((string) $person), 'string');
    }
}
