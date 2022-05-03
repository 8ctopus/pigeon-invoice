<?php

use oct8pus\Invoice\Company;
use oct8pus\Invoice\Discount;
use oct8pus\Invoice\Invoice;
use oct8pus\Invoice\Item;
use oct8pus\Invoice\Person;
use oct8pus\Invoice\Shipping;
use oct8pus\Invoice\Tax;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \oct8pus\Invoice\Invoice
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
            'currency' => '$',
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

        array_push($items, (new Item())->setName('Item 1')->setPrice(4.99)->setQuantity(1));
        array_push($items, (new Item())->setName('Item 2')->setPrice(9.99)->setQuantity(2));
        array_push($items, (new Item())->setName('Item 3')->setPrice(3.99)->setQuantity(3));

        // create invoice
        $invoice = (new Invoice([
            'rootDir' => getcwd(),
            'templatesDir' => getcwd() . '/templates/',
            'locale' => 'ru',
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

        $this->assertEquals($invoice->seller(), $object->seller);
        $this->assertEquals($invoice->buyer(), $object->buyer);

        $this->assertEquals($invoice->date(), $object->date->format('Y-m-d'));
        $this->assertEquals($invoice->number(), $object->number);
        $this->assertEquals($invoice->currency(), $object->currency);

        $this->assertEquals($invoice->discount(), $object->discount);
        $this->assertEquals($invoice->shipping(), $object->shipping);
        $this->assertEquals($invoice->tax(), $object->tax);
        $this->assertEquals($invoice->custom(), (object) $object->custom);
        $this->assertEquals($invoice->items(), $items);

        $this->assertEquals($invoice->subtotal(), $subtotal);
        $this->assertEquals($invoice->taxAmount(), $taxAmount);
        $this->assertEquals($invoice->total(), $total);

        $this->assertEquals(gettype((string) $invoice), 'string');

        $this->assertEquals(gettype((string) $invoice->renderHtml()), 'string');
        $this->assertEquals(gettype((string) $invoice->renderPdf()), 'string');
    }
}
