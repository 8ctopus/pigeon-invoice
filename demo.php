<?php

use oct8pus\Extend\Item;
use oct8pus\Invoice\Company;
use oct8pus\Invoice\Discount;
use oct8pus\Invoice\Invoice;
use oct8pus\Invoice\Person;
use oct8pus\Invoice\Shipping;
use oct8pus\Invoice\Tax;

require_once './vendor/autoload.php';

// command line error handler
(new \NunoMaduro\Collision\Provider())->register();

// create invoice
$invoice = (new Invoice([
    'rootDir' => __DIR__ . DIRECTORY_SEPARATOR . 'resources',
    'templatesDir' => 'templates',
    'locale' => 'ru',
]))
    ->setSeller((new Company())
        ->setName('Widgets LLC')
        ->setStreet1('16 Leo Tolstoy Street')
        ->setZip('119021')
        ->setCity('Moscow')
        ->setCountry('Russia')
        ->setWebsite('https://www.widgets.ru')
        ->setEmail('hello@widgets.ru'))

    ->setBuyer((new Person())
        ->setFirstName('Yuri')
        ->setLastName('Kamasov')
        ->setStreet1('Krasnoarmeyskaya 1')
        ->setZip('620026')
        ->setCity('Yekaterinburg')
        ->setCountry('Russia'))

    ->setDate(new DateTime('28-04-2022'))
    ->setNumber('EN43UD6JA7I2LNBC17')
    ->setCurrency('$')

    // add items
    ->addItem((new Item())->setName('Item 1')->setPrice(4.99)->setQuantity(1)->setVersion(1.000))
    ->addItem((new Item())->setName('Item 2')->setPrice(9.99)->setQuantity(2)->setVersion(1.000))
    ->addItem((new Item())->setName('Item 3')->setPrice(3.99)->setQuantity(3)->setVersion(1.000))

    ->setDiscount((new Discount())->setName('Special Offer')->setPrice(10.00))

    ->setShipping((new Shipping())->setName('Shipping')->setPrice(5.00))

    ->setTax((new Tax())->setName('VAT')->setPercentage(0.21))

    ->setCustomFields([
        'notes' => 'Thank you for shopping with us!',
    ]);

$html = $invoice->renderHtml();

file_put_contents('invoice.html', $html);

$pdf = $invoice->renderPdf();

file_put_contents('invoice.pdf', $pdf);

/*
// output pdf to browser
$dompdf->stream('invoice.pdf', [
    'compress' => true,
    'Attachment' => false,
]);
*/
