<?php

declare(strict_types=1);

namespace Tests;

use Oct8pus\Invoice\Shipping;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Shipping::class)]
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

        self::assertSame($shipping->name(), $object->name);
        self::assertSame($shipping->price(), $object->price);

        //$this->assertEquals(gettype((string) $shipping), 'string');
    }
}
