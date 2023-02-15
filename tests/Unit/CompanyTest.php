<?php

use Oct8pus\Invoice\Company;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Oct8pus\Invoice\Company
 * @covers \Oct8pus\Invoice\Entity
 */
final class CompanyTest extends TestCase
{
    public function testBase() : void
    {
        $object = (object) [
            'name' => 'Widgets LLC',
            'website' => 'https://www.widgets.ru/',
            'street1' => '16 Leo Tolstoy Street',
            'street2' => '-',
            'zip' => '119021',
            'city' => 'Moscow',
            'country' => 'Russia',
            'email' => 'test@yandex.ru',
        ];

        $company = (new Company())
            ->setName($object->name)
            ->setWebsite($object->website)
            ->setStreet1($object->street1)
            ->setStreet2($object->street2)
            ->setZip($object->zip)
            ->setCity($object->city)
            ->setCountry($object->country)
            ->setEmail($object->email);

        static::assertFalse($company->isPerson());
        static::assertTrue($company->isCompany());

        static::assertSame($company->name(), $object->name);
        static::assertSame($company->firstName(), $object->name);
        static::assertSame($company->secondName(), $object->name);

        static::assertSame($company->website(), $object->website);

        static::assertSame($company->street1(), $object->street1);
        static::assertSame($company->street2(), $object->street2);
        static::assertSame($company->zip(), $object->zip);
        static::assertSame($company->city(), $object->city);
        static::assertSame($company->country(), $object->country);

        static::assertSame($company->email(), $object->email);

        static::assertSame(gettype((string) $company), 'string');
    }
}
