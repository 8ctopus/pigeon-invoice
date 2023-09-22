<?php

use Oct8pus\Invoice\Tax;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Oct8pus\Invoice\Tax
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

        self::assertSame($tax->name(), $object->name);
        self::assertSame($tax->percentage(), $object->percentage);

        //$this->assertEquals(gettype((string) $tax), 'string');
    }
}
