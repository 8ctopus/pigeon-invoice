<?php

use oct8pus\Invoice\Tax;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers oct8pus\Invoice\Tax
 */
final class TaxTest extends TestCase
{
    public function testBase() : void
    {
        $object = (object) [
            'name' => 'VAT',
            'percentage' => 0.21,
        ];

        $tax = (new Tax())
            ->setName($object->name)
            ->setPercentage($object->percentage);

        $this->assertEquals($tax->name(), $object->name);
        $this->assertEquals($tax->percentage(), $object->percentage);

        //$this->assertEquals(gettype((string) $tax), 'string');
    }
}
