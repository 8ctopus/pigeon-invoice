<?php

use oct8pus\Invoice\Item;
use PHPUnit\Framework\TestCase;

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

        $this->assertEquals($item->name(), $object->name);
        $this->assertEquals($item->price(), $object->price);
        $this->assertEquals($item->quantity(), $object->quantity);
        $this->assertEquals($item->subtotal(), $object->quantity * $object->price);

        $this->assertEquals(gettype((string) $item), 'string');
    }
}
