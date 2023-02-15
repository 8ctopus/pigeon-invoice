<?php

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

        static::assertTrue($person->isPerson());
        static::assertFalse($person->isCompany());

        Locale::setDefault('en');

        static::assertSame($person->firstName(), $object->firstName);
        static::assertSame($person->secondName(), $object->lastName);
        static::assertSame($person->name(), "{$object->firstName} {$object->lastName}");

        Locale::setDefault('ru');

        static::assertSame($person->name(), "{$object->lastName} {$object->firstName}");

        static::assertSame($person->street1(), $object->street1);
        static::assertSame($person->street2(), $object->street2);
        static::assertSame($person->zip(), $object->zip);
        static::assertSame($person->city(), $object->city);
        static::assertSame($person->country(), $object->country);
        static::assertSame($person->email(), $object->email);

        static::assertSame(gettype((string) $person), 'string');
    }
}
