<?php

declare(strict_types=1);

namespace Tests;

use Oct8pus\Invoice\Company;
use Oct8pus\Invoice\Entity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Company::class)]
#[CoversClass(Entity::class)]
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

        /** @disregard P1013 */
        $company = (new Company())
            ->setName($object->name)
            ->setWebsite($object->website)
            ->setStreet1($object->street1)
            ->setStreet2($object->street2)
            ->setZip($object->zip)
            ->setCity($object->city)
            ->setCountry($object->country)
            ->setEmail($object->email);

        self::assertSame($company->type(), 'Company');

        self::assertSame($company->name(), $object->name);
        self::assertSame($company->firstName(), $object->name);
        self::assertSame($company->secondName(), $object->name);

        self::assertSame($company->website(), $object->website);

        self::assertSame($company->street1(), $object->street1);
        self::assertSame($company->street2(), $object->street2);
        self::assertSame($company->zip(), $object->zip);
        self::assertSame($company->city(), $object->city);
        self::assertSame($company->country(), $object->country);

        self::assertSame($company->email(), $object->email);

        self::assertSame(gettype((string) $company), 'string');
    }
}
