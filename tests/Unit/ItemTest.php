<?php

declare(strict_types=1);

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

        self::assertSame($item->name(), $object->name);
        self::assertSame($item->price(), $object->price);
        self::assertEquals($item->quantity(), $object->quantity);
        self::assertSame($item->subtotal(), $object->quantity * $object->price);

        self::assertSame(gettype((string) $item), 'string');
    }
}
