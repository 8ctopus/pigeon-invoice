<?php

use oct8pus\Invoice\Person;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers oct8pus\Invoice\Person
 * @covers oct8pus\Invoice\Entity
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

        $this->assertTrue($person->isPerson());
        $this->assertFalse($person->isCompany());

        Locale::setDefault('en');

        $this->assertEquals($person->firstName(), $object->firstName);
        $this->assertEquals($person->secondName(), $object->lastName);
        $this->assertEquals($person->name(), "{$object->firstName} {$object->lastName}");

        Locale::setDefault('ru');

        $this->assertEquals($person->name(), "{$object->lastName} {$object->firstName}");

        $this->assertEquals($person->street1(), $object->street1);
        $this->assertEquals($person->street2(), $object->street2);
        $this->assertEquals($person->zip(), $object->zip);
        $this->assertEquals($person->city(), $object->city);
        $this->assertEquals($person->country(), $object->country);
        $this->assertEquals($person->email(), $object->email);

        $this->assertEquals(gettype((string) $person), 'string');
    }
}
