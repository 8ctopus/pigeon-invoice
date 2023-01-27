<?php

use Oct8pus\Invoice\Shipping;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Oct8pus\Invoice\Shipping
 */
final class ShippingTest extends TestCase
{
    public function testBase() : void
    {
        $object = (object) [
            'name' => 'Shipping',
            'price' => 4.99,
        ];

        $shipping = (new Shipping())
            ->setName($object->name)
            ->setPrice($object->price);

        $this->assertEquals($shipping->name(), $object->name);
        $this->assertEquals($shipping->price(), $object->price);

        //$this->assertEquals(gettype((string) $shipping), 'string');
    }
}
