<?php

declare(strict_types=1);

namespace Tests;

use Oct8pus\Invoice\Discount;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Oct8pus\Invoice\Discount
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

        self::assertSame($discount->name(), $object->name);
        self::assertSame($discount->price(), $object->price);

        //$this->assertEquals(gettype((string) $discount), 'string');
    }
}
