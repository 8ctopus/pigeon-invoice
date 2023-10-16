<?php

declare(strict_types=1);

use Oct8pus\Invoice\Company;
use Oct8pus\Invoice\Discount;
use Oct8pus\Invoice\Invoice;
use Oct8pus\Invoice\Item;
use Oct8pus\Invoice\Person;
use Oct8pus\Invoice\Shipping;
use Oct8pus\Invoice\Tax;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Oct8pus\Invoice\Invoice
 */
final class InvoiceTest extends TestCase
{
    public function testBase() : void
    {
        $object = (object) [
            'seller' => (new Company())
                ->setName('Widgets LLC')
                ->setWebsite('https://www.widgets.ru')
                ->setEmail('hello@widgets.ru')
                ->setStreet1('16 Leo Tolstoy Street')
                ->setZip('119021')
                ->setCity('Moscow')
                ->setCountry('Russia'),
            'buyer' => (new Person())
                ->setFirstName('Yuri')
                ->setLastName('Kamasov')
                ->setStreet1('Krasnoarmeyskaya 1')
                ->setZip('620026')
                ->setCity('Yekaterinburg')
                ->setCountry('Russia'),
            'date' => new DateTime('28-04-2022'),
            'number' => 'EN43UD6JA7I2LNBC17',
            'currency' => 'USD',
            'discount' => (new Discount())
                ->setName('Special Offer')
                ->setPrice(10.00),
            'shipping' => (new Shipping())
                ->setName('Shipping')
                ->setPrice(5.00),
            'tax' => (new Tax())
                ->setName('VAT')
                ->setPercentage(0.21),
            'custom' => [
                'notes' => 'Thank you for shopping with us!',
            ],
        ];

        $items = [];

        $items[] = (new Item())->setName('Item 1')->setPrice(4.99)->setQuantity(1);
        $items[] = (new Item())->setName('Item 2')->setPrice(9.99)->setQuantity(2);
        $items[] = (new Item())->setName('Item 3')->setPrice(3.99)->setQuantity(3);

        // create invoice
        $invoice = (new Invoice([
            'rootDir' => getcwd() . DIRECTORY_SEPARATOR . 'resources',
            'templatesDir' => 'templates',
            'locale' => 'en',
        ]))
            ->setSeller($object->seller)
            ->setBuyer($object->buyer)

            ->setDate($object->date)
            ->setNumber($object->number)
            ->setCurrency($object->currency)

            ->setDiscount($object->discount)
            ->setShipping($object->shipping)
            ->setTax($object->tax)

            ->setCustomFields($object->custom);

        $subtotal = 0;

        foreach ($items as $item) {
            $invoice->addItem($item);

            $subtotal += $item->quantity() * $item->price();
        }

        $taxAmount = $object->tax->percentage() * ($subtotal + $object->shipping->price() - $object->discount->price());
        $total = $subtotal + $object->shipping->price() - $object->discount->price() + $taxAmount;

        self::assertSame($invoice->seller(), $object->seller);
        self::assertSame($invoice->buyer(), $object->buyer);

        self::assertSame($invoice->date(), $object->date);
        self::assertSame($invoice->number(), $object->number);
        self::assertSame($invoice->currency(), $object->currency);

        self::assertSame($invoice->discount(), $object->discount);
        self::assertSame($invoice->shipping(), $object->shipping);
        self::assertSame($invoice->tax(), $object->tax);
        self::assertEquals($invoice->custom(), (object) $object->custom);
        self::assertSame($invoice->items(), $items);

        self::assertSame($invoice->subtotal(), $subtotal);
        self::assertSame($invoice->taxAmount(), $taxAmount);
        self::assertSame($invoice->total(), $total);

        self::assertSame(gettype((string) $invoice), 'string');

        self::assertSame(gettype((string) $invoice->renderHtml()), 'string');
        self::assertSame(gettype((string) $invoice->renderPdf()), 'string');
    }
}
