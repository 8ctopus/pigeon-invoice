<?php

use Oct8pus\Invoice\Item;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Oct8pus\Invoice\Item
 */
final class ItemTest extends TestCase
{
    public function testBase() : void
    {
        $object = (object) [
            'name' => 'Item 1',
            'price' => 4.99,
            'quantity' => 1,
        ];

        $item = (new Item())
            ->setName($object->name)
            ->setPrice($object->price)
            ->setQuantity($object->quantity);

        static::assertSame($item->name(), $object->name);
        static::assertSame($item->price(), $object->price);
        static::assertEquals($item->quantity(), $object->quantity);
        static::assertSame($item->subtotal(), $object->quantity * $object->price);

        static::assertSame(gettype((string) $item), 'string');
    }
}
