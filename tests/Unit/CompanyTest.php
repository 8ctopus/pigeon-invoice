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

        $this->assertFalse($company->isPerson());
        $this->assertTrue($company->isCompany());

        $this->assertEquals($company->name(), $object->name);
        $this->assertEquals($company->firstName(), $object->name);
        $this->assertEquals($company->secondName(), $object->name);

        $this->assertEquals($company->website(), $object->website);

        $this->assertEquals($company->street1(), $object->street1);
        $this->assertEquals($company->street2(), $object->street2);
        $this->assertEquals($company->zip(), $object->zip);
        $this->assertEquals($company->city(), $object->city);
        $this->assertEquals($company->country(), $object->country);

        $this->assertEquals($company->email(), $object->email);

        $this->assertEquals(gettype((string) $company), 'string');
    }
}
