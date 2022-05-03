<?php

use oct8pus\Invoice\Discount;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers oct8pus\Invoice\Discount
 */
final class DiscountTest extends TestCase
{
    public function testBase() : void
    {
        $object = (object) [
            'name' => 'Discount',
            'price' => 4.99,
        ];

        $discount = (new Discount())
            ->setName($object->name)
            ->setPrice($object->price);

        $this->assertEquals($discount->name(), $object->name);
        $this->assertEquals($discount->price(), $object->price);

        //$this->assertEquals(gettype((string) $discount), 'string');
    }
}
